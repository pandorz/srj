<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\DemandeNewsletter;
use AppBundle\Entity\Statistique;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class StatistiqueListener
 * @package AppBundle\EventListener
 */
class StatistiqueListener
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
    public function postPersist(LifecycleEventArgs $args)
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