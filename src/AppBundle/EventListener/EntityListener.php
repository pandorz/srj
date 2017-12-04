<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\DemandeNewsletter;
use AppBundle\Entity\Statistique;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UtilisateurLog;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class EntityListener
 * @package AppBundle\EventListener
 */
class EntityListener
{
    private $tokenStorage;

    /**
     * EntityListener constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->setLog($args, __FUNCTION__);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->setLog($args, __FUNCTION__);
        $this->setStatistique($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->setLog($args, __FUNCTION__);
    }

    /**
     * @param LifecycleEventArgs $args
     * @param $eventType
     */
    private function setLog(LifecycleEventArgs $args, $eventType)
    {
        $entity = $args->getEntity();

        if (!($entity instanceof UtilisateurLog)) {
            $utilisateurLog = $this->constructUtilisateurLog($entity);

            if (!is_null($utilisateurLog)) {
                $utilisateurLog->setEventType($eventType);
                $em = $args->getEntityManager();
                $em->persist($utilisateurLog);
                $em->flush();
            }
        }
    }

    /**
     * @param $entity
     * @return UtilisateurLog|null
     */
    private function constructUtilisateurLog($entity)
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->tokenStorage->getToken()->getUser();

        if ($utilisateur instanceof Utilisateur) {
            $utilisateurLog = new UtilisateurLog();
            $utilisateurLog->setEntityId($entity->getId());
            $utilisateurLog->setUtilisateurId($utilisateur->getId());
            $utilisateurLog->setNumeroMembre($utilisateur->getMembreNumero());
            $utilisateurLog->setEntityName(get_class($entity));
            return $utilisateurLog;
        }
        return null;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function setStatistique(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof DemandeNewsletter) {
            $em = $args->getEntityManager();
            $statitisque = $em->getRepository(Statistique::class)->findOneByTimestampCreation((new \DateTime()));

            if ($statitisque instanceof Statistique) {
                $statitisque->setOccurence(($statitisque->getOccurence() + 1));
            } else {
                $statitisque = new Statistique();
                $statitisque->setEntityName(get_class($entity));
                $statitisque->setOccurence(1);
            }

            $em->persist($statitisque);
            $em->flush();
        }
    }
}