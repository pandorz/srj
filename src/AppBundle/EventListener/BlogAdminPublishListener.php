<?php
namespace AppBundle\EventListener;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogAdminPublishListener implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    public function guardAdminPublish(GuardEvent $event)
    {
        if (false === $this->authChecker->isGranted('ROLE_SONATA_ADMIN')) {
            $event->setBlocked(true);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.blog.guard.admin_publish' => array('guardAdminPublish'),
        ];
    }
}