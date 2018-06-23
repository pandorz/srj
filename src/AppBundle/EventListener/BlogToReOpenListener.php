<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogToReOpenListener implements EventSubscriberInterface
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    public function __construct(TokenStorage $tokenStorage, AuthorizationCheckerInterface $authChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authChecker = $authChecker;
    }

    public function guardToReopen(GuardEvent $event)
    {
        /** @var Blog $blog */
        $blog = $event->getSubject();

        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->tokenStorage->getToken()->getUser();
        if (! $blog->getAuteurs()->contains($utilisateur) || false === $this->authChecker->isGranted('ROLE_SONATA_ADMIN')) {
            $event->setBlocked(true);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.blog.guard.to_reopen' => array('guardToReopen'),
        ];
    }
}