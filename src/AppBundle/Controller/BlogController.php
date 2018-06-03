<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlogController
 * @package AppBundle\Controller
 */
class BlogController extends BaseController
{
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function rejectAction($id)
    {
        if (!is_numeric($id) || empty($id)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $blog = $this->get("doctrine.orm.entity_manager")->getRepository(Blog::class)->find($id);

        if (!($blog instanceof Blog)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.workflow.blog')->rejeter($blog);

        return $this->redirectToRoute('admin_blog_edit', ['id' => $blog->getId()]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function toReviewAction($id)
    {
        if (!is_numeric($id) || empty($id)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $blog = $this->get("doctrine.orm.entity_manager")->getRepository(Blog::class)->find($id);

        if (!($blog instanceof Blog)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.workflow.blog')->relecture($blog);

        return $this->redirectToRoute('admin_blog_edit', ['id' => $blog->getId()]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function toReopenAction($id)
    {
        if (!is_numeric($id) || empty($id)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $blog = $this->get("doctrine.orm.entity_manager")->getRepository(Blog::class)->find($id);

        if (!($blog instanceof Blog)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.workflow.blog')->reouvrir($blog);

        return $this->redirectToRoute('admin_blog_edit', ['id' => $blog->getId()]);
    }
}
