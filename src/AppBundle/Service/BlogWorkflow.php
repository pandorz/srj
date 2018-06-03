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

    /**
     * @param Blog $blog
     * @return bool
     */
    public function rejeter(Blog $blog)
    {
        $states = $blog->getCurrentPlace();
        // deja rejete
        if (is_array($states) && isset($states['rejected']) && $states['rejected']==1) {
            return true;
        }

        if ($this->blogWorkflow->can($blog, 'reject')) {
            $this->blogWorkflow->apply($blog, 'reject');
            $this->em->flush();
            return true;
        }

        return false;
    }

    /**
     * @param Blog $blog
     * @return bool
     */
    public function relecture(Blog $blog)
    {
        $states = $blog->getCurrentPlace();
        // deja en relecture
        if (is_array($states) && isset($states['review']) && $states['review']==1) {
            return true;
        }

        if ($this->blogWorkflow->can($blog, 'to_review')) {
            $this->blogWorkflow->apply($blog, 'to_review');
            $this->em->flush();
            return true;
        }

        return false;
    }

    /**
     * @param Blog $blog
     * @return bool
     */
    public function reouvrir(Blog $blog)
    {
        $states = $blog->getCurrentPlace();
        // deja en relecture
        if (is_array($states) && isset($states['review']) && $states['review']==1) {
            return true;
        }

        if ($this->blogWorkflow->can($blog, 'to_reopen')) {
            $this->blogWorkflow->apply($blog, 'to_reopen');
            $this->em->flush();
            return true;
        }

        return false;
    }

    /**
     * @param Blog $blog
     * @return bool
     */
    public function canBePublished(Blog $blog)
    {
        return $this->blogWorkflow->can($blog, 'publish') or $this->blogWorkflow->can($blog, 'admin_publish');
    }
}