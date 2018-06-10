<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Cour;
use AppBundle\Entity\DemandeNewsletter;
use AppBundle\Entity\Partenaire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\BlogType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package AppBundle\Controller\Front
 *
 * * -------------------- *
 * @Route("/mon-espace")
 * -------------------- *
 */
class DashboardController extends BaseController
{
    /**
     * Dashboard
     *
     * -------------------- *
     * @Route("/", name="my_space")
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        /** @var Utilisateur $user */
        $user = $this->getUser();
        if (!$user->getAccesSite()) {
            return $this->redirectToRoute('fos_user_security_logout');
        }
        return $this->render('front/users/my_space/dashboard.html.twig');
    }

    /**
     * Dashboard
     *
     * -------------------- *
     * @Route("/article", name="add_article")
     * @Route("/article/{slug}", name="edit_article")
     * @Method({"GET", "POST"})
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction(Request $request, $slug = null)
    {
        if (!is_null($slug)) {
            $blog = $this->getEm()->getRepository(Blog::class)->findOneBySlug($slug);
        }

        if (is_null($slug) || (isset($blog) && empty($blog))) {
            $blog = new Blog();
            $blog->addAuteur($this->getUser());
        }

        $form = $this->createForm(BlogType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->bindRequest($request);
            // TODO tag
            // TODO workflow
            $this->getEm()->persist($blog);
            $this->getEm()->flush();
        }

        return $this->render('front/users/my_space/article_form.html.twig', ['form' => $form->createView()]);
    }
}
