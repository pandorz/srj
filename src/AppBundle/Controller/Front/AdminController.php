<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Blog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AdminController
 *
 * @package AppBundle\Controller\Front
 *
 * -------------------- *
 * @Route("/admin")
 * -------------------- *
 */
class AdminController extends BaseController
{

    /**
     *
     * -------------------- *
     * @Route("/blog/article/{slug}/", name="admin_blog_detail")
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction($slug)
    {
        /** @var Blog $blog */
        $blog = $this->getEm()->getRepository(Blog::class)->findOneBySlug($slug);
        if (empty($blog)) {
            return $this->redirectToRoute('blog');
        }

        return $this->render('front/blog/blog-detail.html.twig', ['blog' => $blog]);
    }
}
