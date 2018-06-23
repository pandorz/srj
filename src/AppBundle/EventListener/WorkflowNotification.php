<?php
namespace AppBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class WorkflowNotification implements EventSubscriberInterface
{
    public function onLeave(Event $event)
    {
        // TODO : Une entrée dans une table notificatio avec le user auteur
//        $this->logger->alert(sprintf(
//            'Blog post (id: "%s") performed transaction "%s" from "%s" to "%s"',
//            $event->getSubject()->getId(),
//            $event->getTransition()->getName(),
//            implode(', ', array_keys($event->getMarking()->getPlaces())),
//            implode(', ', $event->getTransition()->getTos())
//        ));
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.blog_publishing.leave' => 'onLeave',
        ];
    }
}