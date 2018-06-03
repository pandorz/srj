<?php

namespace AppBundle\Service;


use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Import as ImportEntity;
use Doctrine\ORM\EntityManager;
use Liuggio\ExcelBundle\Factory;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Monolog\Logger;

class Import
{
    const SAVE_PATH = "imports";

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var ImportEntity
     */
    private $importEntity;

    /**
     * @var string
     */
    private $logs;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var Factory
     */
    private $phpExcelService;

    /**
     * @var array
     */
    private $header;

    /**
     * @var array
     */
    private $correspondanceCSV;

    /**
     * @var string
     */
    private $uploadPath;

    /**
     * Import constructor.
     * @param EntityManager $em
     * @param Logger $logger
     * @param Factory $phpExcelService
     * @param ValidatorInterface $validator
     * @param string $uploadPath
     */
    public function __construct(EntityManager $em, Logger $logger, Factory $phpExcelService, ValidatorInterface $validator, string $uploadPath)
    {
        $this->em               = $em;
        $this->logger           = $logger;
        $this->phpExcelService  = $phpExcelService;
        $this->validator        = $validator;
        $this->uploadPath       = $uploadPath;
        $this->setHeader();
    }

    /**
     * @param $idImport
     * @return bool
     */
    public function execute($idImport)
    {
        if ($this->setImportEntity($idImport)) {
            $filePath  = $this->importEntity->getFilepath();
            $lines     = $this->getData($filePath);

            $this->logger->addInfo("Début de l'import pour l'id ".$idImport);
            if (is_null($lines)) {
                $this->setCriticalError("Impossible de lire le fichier '".$filePath."'");
                return false;
            }

            foreach ($lines as $lineNumber => $line) {
                if ($lineNumber==0) {
                    if (!$this->isHeaderOk($line)) {
                        $this->setCriticalError("L'entête du fichier '".$filePath."' ne correspond pas au format attendu");
                    }
                } else {
                    if ($this->isLineOk($line, $lineNumber)) {
                        $user = $this->insertOrUpdateUser($line);
                        $this->getEm()->persist($user);
                        $this->addLog("Insertion ou mise à jour du membre ".$user->getMembreNumero()." (Ligne ".$lineNumber.")");
                    } elseif ($this->importEntity->getStatut() != ImportEntity::STATUT_WARNING) {
                        $this->importEntity->setStatut(ImportEntity::STATUT_WARNING);
                    }
                }
            }
            $this->logger->addInfo("Fin de l'import pour l'id ".$idImport);
            if ($this->importEntity->getStatut() != ImportEntity::STATUT_WARNING) {
                $this->importEntity->setStatut(ImportEntity::STATUT_OK);
            }

            $this->saveLog();
        } else {
            $this->importEntity->setTimestampExecution(new \DateTime());
            $this->setCriticalError("Impossible de lancer l'import");
            return false;
        }

        try {
            $this->getEm()->flush();
        } catch (\Exception $e) {
            $this->getEm()->clear();
            $this->setCriticalError("Erreur à la fin de l'import");
            return false;
        }

        return true;
    }

    /**
     * @param string $textError
     */
    private function setCriticalError(string $textError)
    {
        $this->importEntity->setStatut(ImportEntity::STATUT_KO);
        $this->getEm()->persist($this->importEntity);
        $this->getEm()->flush();
        $this->logger->addCritical($textError);
    }

    /**
     * @param string $filePath
     * @return array|null
     */
    private function getData(string $filePath)
    {
        if ($this->isCsvFile($filePath)) {
            return $this->getDataFromCsv($filePath);
        }

        if ($this->isXlsFile($filePath)) {
            return $this->getDataFromXls($filePath);
        }

        return null;
    }

    /**
     * @param string $filePath
     * @return bool
     */
    private function isCsvFile(string $filePath)
    {
        $infoFile = pathinfo($filePath);
        return hash_equals($infoFile['extension'], 'csv');
    }

    /**
     * @param string $filePath
     * @return bool
     */
    private function isXlsFile(string $filePath)
    {
        $infoFile = pathinfo($filePath);
        return hash_equals($infoFile['extension'], 'xls') || hash_equals($infoFile['extension'], 'xlsx');
    }

    /**
     * @param $idImport
     * @return bool
     */
    private function setImportEntity($idImport)
    {
        if (!is_numeric($idImport) || empty($idImport)) {
            return false;
        }

        /** @var ImportEntity $import */
        $import = $this->getEm()->getRepository(ImportEntity::class)->find($idImport);

        if (empty($import) || $import->getStatut() != ImportEntity::STATUT_ATTENTE || empty($import->getFilepath())) {
            return false;
        }

        $this->importEntity = $import;

        $this->importEntity->setStatut(ImportEntity::STATUT_LOCK);
        $this->importEntity->setTimestampExecution(new \DateTime());
        $this->getEm()->persist($this->importEntity);
        $this->getEm()->flush();


        return true;
    }

    /**
     * @param array $line
     * @return bool
     */
    private function isHeaderOk(array &$line)
    {
        $this->setCorrespondanceHeaderCsv();
        $cleanData = [];
        foreach ($this->correspondanceCSV as $fileTitle => $cleanTitle) {
            if (!array_key_exists($fileTitle, $line) && !array_key_exists($cleanTitle, $line)) {
                return false;
            } else {
                $current_data = (!array_key_exists($fileTitle, $line) ? $line[$cleanTitle] : $line[$fileTitle]);
                $cleanData[$cleanTitle] = $current_data;
            }
        }
        $line                = $cleanData;
        $this->isHeaderCsvOk = true;

        return true;
    }

    /**
     * @param array $line
     * @param int $lineNumber
     * @return bool
     */
    private function isLineOk(array $line, int $lineNumber)
    {
        $isValid = true;

        if (empty($line)) {
            $isValid = false;
            $this->addLog("La ligne ".$lineNumber." est vide");
        }

        if (count($line) < count($this->header)) {
            $isValid = false;
            $this->addLog("Ligne ".$lineNumber.", nombre de colonne insuffisant");
        }

        if (empty(trim($line['numero_membre']))) {
            $isValid = false;
            $this->addLog("Le numéro de membre ne peut être vide ligne ".$lineNumber);
        }

        if (empty(trim($line['mail']))) {
            $isValid = false;
            $this->addLog("Le mail ne peut être vide ligne ".$lineNumber);
        }

        if ($this->isMailAlreadyUsed(trim($line['mail']), trim($line['numero_membre']))) {
            $isValid = false;
            $this->addLog("L'adresse mail ".$line['mail']." est déjà utilisé ".$lineNumber);
        }

        if (empty(trim($line['nom']))) {
            $isValid = false;
            $this->addLog("Le nom ne peut être vide ligne ".$lineNumber);
        }

        if (empty(trim($line['prenom']))) {
            $isValid = false;
            $this->addLog("Le prénom ne peut être vide ligne ".$lineNumber);
        }

        if ($isValid) {
            $user   = $this->insertOrUpdateUser($line);
            $errors = $this->validator->validate($user);

            if ($errors->count() > 0) {
                $isValid = false;

                /** @var ConstraintViolationInterface $error */
                foreach ($errors as $error) {
                    $this->addLog(
                        "Valeur invalide ligne ".$lineNumber." : ".
                        \array_flip($this->correspondanceCSV)[$error->getPropertyPath()]." Détails -> ".
                        $error->getMessage()
                    );
                }
            }
        }

        return $isValid;
    }

    /**
     * @param string $memberNumber
     * @return Utilisateur|null
     */
    private function getUserByMemberNumber(string $memberNumber)
    {
        $user = $this->getEm()->getRepository(Utilisateur::class)->findOneByMembreNumero($memberNumber);

        if (empty($user)) {
            return null;
        }

        return $user;
    }

    /**
     * @param string $memberNumber
     * @param string $username
     * @return bool
     */
    private function usernameAllreadyUsed(string $memberNumber, string $username)
    {
        $users = $this->getEm()->getRepository(Utilisateur::class)->findByUsername($username);

        if (empty($users)) {
            return false;
        }

        if (empty($memberNumber)) {
            return true;
        }

        /** @var Utilisateur $user */
        foreach ($users as $user) {
            if (empty($user->getMembreNumero())) {
                return true;
            } elseif (hash_equals($user->getMembreNumero(), $memberNumber)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $line
     * @return Utilisateur
     */
    private function insertOrUpdateUser(array $line)
    {
        $user = $this->getUserByMemberNumber(trim($line['numero_membre']));
        if (is_null($user)) {
            $user = new Utilisateur();
        }
        $user = $this->setUser($line, $user);

        return $user;
    }

    /**
     * @param array $line
     * @param Utilisateur $user
     * @return Utilisateur
     */
    private function setUser(array $line, Utilisateur $user)
    {
        $user->setEmail(trim($line['mail']));
        $user->setLastname(trim($line['nom']));
        $user->setFirstname(trim($line['prenom']));
        $user->setMembreNumero(trim($line['numero_membre']));

        if (!empty(trim($line['nomJP']))) {
            $user->setNomJaponais(trim($line['nomJP']));
        }

        if (!empty(trim($line['nomJP']))) {
            $user->setPrenomJaponais(trim($line['prenomJP']));
        }

        if (empty($user->getUsername())) {
            $user->setUsername($this->generateUsername($user->getMembreNumero(), $user->getFirstname() ,$user->getLastname()));
        }

        $user->setPassword($this->generatePassword());

        $user = $this->addToGroup($user);
        return $user;
    }

    /**
     * @param string $memberNumber
     * @param string $firstname
     * @param string $lastname
     * @param int $occurence
     * @return string
     */
    private function generateUsername(string $memberNumber, string $firstname, string $lastname, int $occurence = 0)
    {
        $username = mb_strtolower(ucfirst($firstname).$lastname).($occurence>0?$occurence:'');

        if ($this->usernameAllreadyUsed()) {
            return $this->generateUsername($memberNumber, $firstname, $lastname, ($occurence+1));
        }

        return $username;
    }

    /**
     * @param Utilisateur $user
     * @return Utilisateur
     */
    private function addToGroup(Utilisateur $user)
    {
        $group = $this->importEntity->getFkUtilisateurDroit();
        if (!empty($group) && !$user->hasGroup($group)) {
            $user->addGroup($group);
        }

        return $user;
    }

    private function saveLog()
    {
        $filePath = $this->createFileLog();
        $file = fopen($filePath, 'r+');
        fputs($file, $this->logs);
        fclose($file);
        $this->importEntity->setFilepathLog($filePath);
        $this->getEm()->persist($this->importEntity);
    }

    /**
     * @return string
     */
    private function createFileLog()
    {
        $dirPath =  $this->uploadPath.DIRECTORY_SEPARATOR.
            DIRECTORY_SEPARATOR.self::SAVE_PATH;

        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0766, true);
        }

        $file_path = $dirPath.DIRECTORY_SEPARATOR.
            $this->importEntity->getId()."_".time().".txt";

        if (file_exists($file_path)) {
            return realpath($file_path);
        } else {
            $file = fopen($file_path, 'a+');
            fclose($file);
            return realpath($file_path);
        }
    }

    /**
     * @param string $texte
     */
    private function addLog(string $texte)
    {
        $this->logs.= "\n [".date("Y-m-d H:i:s")."] ".$texte;
    }

    private function setHeader()
    {
        $this->header = [
            'numero_membre',
            'nom',
            'prenom',
            'mail',
            'nomJP',
            'prenomJP'
        ];
    }

    /**
     * Array title vs File title
     */
    private function setCorrespondanceHeaderCsv()
    {
        $this->correspondanceCSV = [
            'Numéro de membre'  => 'numero_membre',
            'Nom'               => 'nom',
            'Prénom'            => 'prenom',
            'Adresse mail'      => 'mail',
            'Nom (JP)'          => 'nomJP',
            'Prénom (JP)'       => 'prenomJP'
        ];
    }

    /**
     * @param $filePath
     * @return array|null
     */
    private function getDataFromXls($filePath)
    {
        $data = null;

        $excelObject = $this->phpExcelService->createPHPExcelObject($filePath);
        $sheet       = $excelObject->getActiveSheet()->toArray(null, true, true, true);

        if (!is_array($this->header)) {
            $this->setHeader();
        }

        foreach ($sheet as $line) {
            $data[] = [
                'numero_membre' => $line['A'],
                'nom'           => $line['B'],
                'prenom'        => $line['C'],
                'mail'          => $line['D'],
                'nomJP'         => $line['E'],
                'prenomJP'      => $line['F']
            ];
        }

        return $data;
    }

    /**
     * @param $filePath
     * @param string $delimiter
     * @return array
     */
    private function getDataFromCsv($filePath, $delimiter = ',')
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder($delimiter)]);

        $data = $serializer->decode(file_get_contents($filePath), 'csv');

        if (empty($data)) {
            $data  = [];
            $lines = explode("\r", file_get_contents($filePath));

            $cpt_line = 0;
            foreach ($lines as $line) {
                if ($cpt_line > 0) {
                    $columns    = explode(";", $line);
                    $array_temp = [];
                    $cpt_column = 0;
                    foreach ($this->header as $name) {
                        if (isset($columns[$cpt_column])) {
                            $array_temp[$name] = utf8_encode($columns[$cpt_column]);
                        }
                        $cpt_column++;
                    }
                    $data[] = $array_temp;
                }
                $cpt_line++;
            }
        }

        if ((isset($data[0]) && count($data[0]) == 1) || count($data) == 1 && $delimiter == ',') {
            return $this->getDataFromCsv($filePath, ';');
        }

        return $data;
    }

    /**
     * Get entity manager
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     * @throws \Doctrine\ORM\ORMException
     */
    private function getEm()
    {
        // connexion closed après exception critical, réouverture
        if (!$this->em->isOpen()) {
            $em = $this->em->create(
                $this->em->getConnection(),
                $this->em->getConfiguration()
            );

            $this->em = $em;
        }

        return $this->em;
    }

    private function generatePassword()
    {
        return preg_replace('/[+><\(\)~*\"@\/=]+/', '', base64_encode(random_bytes(8)));
    }

    /**
     * @param string $mail
     * @param string $memberNumber
     * @return bool
     */
    private function isMailAlreadyUsed(string $mail, string $memberNumber)
    {
        if (empty($mail)) {
            return false;
        }

        /** @var Utilisateur $user */
        $user = $this->getEm()->getRepository(Utilisateur::class)->findOneByEmail($mail);

        if (empty($user)) {
            return false;
        }

        return !hash_equals($user->getMembreNumero(), $memberNumber);
    }
}
