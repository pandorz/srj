<?php

namespace AppBundle\Controller\Front;


use AppBundle\Entity\Blog;
use AppBundle\Entity\Parametre;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


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
    public function indexAction($plus)
    {
        if (!$this->isActifParamBlog()) {
            return $this->redirectToRoute('home');
        }

        $limit = 6;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }

        $blogs = $this->getTopBlogs($limit);
        return $this->render('front/blog/blog.html.twig', ['blogs' => $blogs]);
    }

    /**
     * Detail
     *
     * -------------------- *
     * @Route("/article/{slug}/", name="blog_detail")
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction($slug)
    {
        if (!$this->isActifParamBlog()) {
            return $this->redirectToRoute('home');
        }

        /** @var Blog $blog */
        $blog = $this->getEm()->getRepository(Blog::class)->findOneBySlug($slug);
        if (empty($blog)) {
            return $this->redirectToRoute('blog');
        }

        if (!$blog->getAffiche() || $blog->getDatePublication() > (new \DateTime())) {
            return $this->redirectToRoute('blog');
        }

        return $this->render('front/blog/blog-detail.html.twig', ['blog' => $blog]);
    }

    /**
     * Possedent le tag
     *
     * -------------------- *
     * @Route("/tag/{slug}/{plus}/", name="blog_tag", defaults={"plus" = "recent"})
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tagAction($slug, $plus)
    {
        if (!$this->isActifParamBlog()) {
            return $this->redirectToRoute('home');
        }

        $limit = 6;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }

        $tag = $this->getEm()
            ->getRepository(Tag::class)
            ->findOneBySlug($slug);
        $tagName = '';
        if ($tag instanceof Tag) {
            $tagName = ucfirst($tag->getNom());
        }

        if (is_null($limit)) {
            $blogs = $tag->getBlogs();
        } else {
            $cpt = 0;
            foreach ($tag->getBlogs() as $blog) {
                if ($cpt < $limit) {
                    $blogs[] = $blog;
                    $cpt++;
                } else {
                    break;
                }
            }
        }
        
        return $this->render('front/blog/blog.html.twig', ['blogs' => $blogs, 'tagName' => $tagName]);
    }

    /**
     * @return bool
     */
    private function isActifParamBlog()
    {
        $parametre = $this->getEm()
            ->getRepository(Parametre::class)
            ->findOneBy(['slug' => 'affichage-blog-public']);

        return (!empty($parametre) && $parametre->getValue() == "1");
    }
}
