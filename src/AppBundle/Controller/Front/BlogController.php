<?php

namespace AppBundle\Controller\Front;


use AppBundle\Entity\Blog;
use AppBundle\Entity\Parametre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class BlogController
 *
 * @package AppBundle\Controller\Front
 *
 * -------------------- *
 * @Route("/blog")
 * -------------------- *
 */
class BlogController extends BaseController
{

    /**
     * Tous
     *
     * -------------------- *
     * @Route("/{plus}/", name="blog", defaults={"plus" = "recent"})
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $plus)
    {
        if (!$this->isActifParamBlog()) {
            return $this->redirectToRoute('home');
        }

        $limit = 6;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }

        $blogs = $this->getTopBlogs($limit);
        return $this->render('blog.html.twig', ['blogs' => $blogs]);
    }

    /**
     * Tous
     *
     * -------------------- *
     * @Route("/article/{slug}/", name="blog_detail")
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction(Request $request, $slug)
    {
        if (!$this->isActifParamBlog()) {
            return $this->redirectToRoute('home');
        }

        $blog = $this->getEm()->getRepository(Blog::class)->findBySlug($slug);
        if (empty($blog)) {
            return $this->redirectToRoute('blog');
        }

        return $this->render('blog-detail.html.twig', ['blog' => $blog]);
    }

    private function isActifParamBlog()
    {
        $parametre = $this->getEm()
            ->getRepository(Parametre::class)
            ->findOneBy(['slug' => 'affichage-blog-public']);

        return (!empty($parametre) && $parametre == "1");
    }
}
