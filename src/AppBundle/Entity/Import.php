<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Import
 *
 * @ORM\Table(name="import")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImportRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Import
{
    /**
     * Statut de l'import : Ok
     */
    const STATUT_OK = 'Terminé';

    /**
     * Statut de l'import : KO
     */
    const STATUT_KO = 'En erreur';

    /**
     * Statut de l'import : KO
     */
    const STATUT_WARNING = 'Incomplet';

    /**
     * Statut de l'import : pas encore fait
     */
    const STATUT_ATTENTE    = 'En attente';

    /**
     * Statut de l'import : en cours
     */
    const STATUT_LOCK       = 'En cours';

    const SERVER_PATH_TO_IMAGE_FOLDER = '/uploads/medias/import';

    const TYPE_MIME = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
        'text/plain',
        'application/octet-stream'
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_creation", type="datetime", nullable=true)
     */
    private $timestampCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_modification", type="datetime", nullable=true)
     */
    private $timestampModification;
    
    /**
     * @var string
     *
     * @ORM\Column(name="utilisateur_creation", type="string", length=255, nullable=true)
     */
    private $utilisateurCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="utilisateur_modification", type="string", length=255, nullable=true)
     */
    private $utilisateurModification;
    
    /**
     * For Sonata Admin Doctrine lock
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Version
     */
    protected $version;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_execution", type="datetime", nullable=true)
     */
    private $timestampExecution;

    /**
     * @var UtilisateurDroits
     *
     * @ORM\ManyToOne(targetEntity="UtilisateurDroits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_group", referencedColumnName="id")
     * })
     */
    private $fkUtilisateurDroit;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     * @ORM\Column(name="filepath", type="string", length=255, nullable=true)
     */
    private $filepath;

    /**
     * @var string
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="filepath_log", type="string", length=255, nullable=true)
     */
    private $filepathLog;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=45, nullable=true)
     */
    private $statut;



    /**
     * Get id
     *
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }
    
    /**
     * @param int $version
     *
     * @return Import
     */
    public function setVersion($version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getVersion():? int
    {
        return $this->version;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->lifecycleFileUpload();
        $this->setTimestampCreation(new \DateTime('now'));
        $this->setStatut(self::STATUT_ATTENTE);
    }

    
    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     *
     * @return Import
     */
    public function setTimestampCreation($timestampCreation): Import
    {
        $this->timestampCreation = $timestampCreation;

        return $this;
    }

    /**
     * Get timestampCreation
     *
     * @return \DateTime
     */
    public function getTimestampCreation():? \DateTime
    {
        return $this->timestampCreation;
    }
    
    /**
     * Set timestampModification
     *
     * @param \DateTime $timestampModification
     *
     * @return Import
     */
    public function setTimestampModification($timestampModification): Import
    {
        $this->timestampModification = $timestampModification;

        return $this;
    }

    /**
     * Get timestampModification
     *
     * @return \DateTime
     */
    public function getTimestampModification():? \DateTime
    {
        return $this->timestampModification;
    }
    
    /**
     * @return string
     */
    public function getUtilisateurCreation():? string
    {
        return $this->utilisateurCreation;
    }

    /**
     * @param string $utilisateurCreation
     */
    public function setUtilisateurCreation($utilisateurCreation)
    {
        $this->utilisateurCreation = $utilisateurCreation;
    }

    /**
     * @return string
     */
    public function getUtilisateurModification():? string
    {
        return $this->utilisateurModification;
    }

    /**
     * @param string $utilisateurModification
     */
    public function setUtilisateurModification($utilisateurModification)
    {
        $this->utilisateurModification = $utilisateurModification;
    }

    /**
     * @return UtilisateurDroits
     */
    public function getFkUtilisateurDroit():? UtilisateurDroits
    {
        return $this->fkUtilisateurDroit;
    }

    /**
     * @param UtilisateurDroits $fkUtilisateurDroit
     */
    public function setFkUtilisateurDroit(UtilisateurDroits $fkUtilisateurDroit)
    {
        $this->fkUtilisateurDroit = $fkUtilisateurDroit;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $dirPath = '../web'.self::SERVER_PATH_TO_IMAGE_FOLDER;

        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0766, true);
        }

        $path = realpath($dirPath);

        // move takes the target directory and target filename as params
        $this->getFile()->move(
            $path,
            $this->getFile()->getClientOriginalName()
        );

        $this->filename = $this->getFile()->getClientOriginalName();
        $this->filepath = $path.DIRECTORY_SEPARATOR.$this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }


    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setTimestampCreation(new \DateTime());
    }



    /**
     * @return string
     */
    public function getStatutWithStyle()
    {
        $label = "label-success";

        if (hash_equals($this->statut, self::STATUT_KO)) {
            $label = "label-danger";
        }

        if (hash_equals($this->statut, self::STATUT_WARNING)) {
            $label = "label-warning";
        }

        if (hash_equals($this->statut, self::STATUT_LOCK)) {
            $label = "label-default";
        }

        if (hash_equals($this->statut, self::STATUT_ATTENTE)) {
            $label = "label-info";
        }

        return '<span class="label '.$label.'">'.$this->statut.'</span>';
    }

    /**
     * @return UploadedFile
     */
    public function getFile():? UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFilepath():? string
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     */
    public function setFilepath(string $filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @return string
     */
    public function getFilename():? string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilepathLog():? string
    {
        return $this->filepathLog;
    }

    /**
     * @param string $filepathLog
     */
    public function setFilepathLog(string $filepathLog)
    {
        $this->filepathLog = $filepathLog;
    }

    /**
     * @return string
     */
    public function getStatut():? string
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     */
    public function setStatut(string $statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return \DateTime
     */
    public function getTimestampExecution():? \DateTime
    {
        return $this->timestampExecution;
    }

    /**
     * @param \DateTime $timestampExecution
     */
    public function setTimestampExecution(\DateTime $timestampExecution)
    {
        $this->timestampExecution = $timestampExecution;
    }
}
