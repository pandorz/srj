<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Blog;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogPublishListener implements EventSubscriberInterface
{

    public function guardPublish(GuardEvent $event)
    {
        /** @var Blog $blog */
        $blog = $event->getSubject();

        if (!$blog->getAffiche()) {
            $event->setBlocked(true);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.blog.guard.publish' => ['guardPublish'],
        ];
    }
}