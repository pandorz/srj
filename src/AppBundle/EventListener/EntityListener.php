<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UtilisateurLog;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class EntityListener
{
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $this->setLog($args, __FUNCTION__);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->setLog($args, __FUNCTION__);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->setLog($args, __FUNCTION__);
    }

    private function setLog(LifecycleEventArgs $args, string $eventType)
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
}