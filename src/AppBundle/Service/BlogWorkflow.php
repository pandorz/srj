<?php

namespace AppBundle\Service;

use AppBundle\Entity\Blog;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Workflow\Workflow;

class BlogWorkflow
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Workflow
     */
    private $blogWorkflow;

    public function __construct(EntityManager $em, Workflow $blogWorkflow)
    {
        $this->em           = $em;
        $this->blogWorkflow = $blogWorkflow;
    }

    /**
     * @param Blog $blog
     * @return bool
     */
    public function publier(Blog $blog)
    {
        $publied = false;

        $states = $blog->getCurrentPlace();
        // deja publie
        if (is_array($states) && isset($states['published']) && $states['published']==1) {
            return true;
        }

        if ($this->blogWorkflow->can($blog, 'publish')) {
            $this->blogWorkflow->apply($blog, 'publish');
            $publied = true;
        }

        if ($this->blogWorkflow->can($blog, 'admin_publish')) {
            $this->blogWorkflow->apply($blog, 'admin_publish');
            $publied = true;
        }

        if ($publied) {
            $this->em->flush();
        }

        return $publied;
    }
}