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
     * Dashboard add/edit article
     *
     * -------------------- *
     * @Route("/article", name="add_article")
     * @Route("/article/{slug}", name="edit_article")
     * @Method({"GET", "POST"})
     * -------------------- *
     *
     * @param Request $request
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction(Request $request, $slug = null)
    {
        $user = $this->getUser();
        if (!$user->getAccesSite()) {
            return $this->redirectToRoute('fos_user_security_logout');
        }

        if (!is_null($slug)) {
            $blog = $this->getEm()->getRepository(Blog::class)->findOneBySlug($slug);
        }

        if (is_null($slug) || (isset($blog) && empty($blog))) {
            $blog = new Blog();
            $blog->addAuteur($this->getUser());
        }

        // Ne peut pas etre edité
        $serviceWorkflow = $this->get('app.workflow.blog');
        if (!$serviceWorkflow->canBeReview($blog)) {
            $request->getSession()
                ->getFlashBag()
                ->add('info', $this->getTranslator()->trans(
                    'my_space.info.cant_be_edited',
                    [],
                    'validators'
                ));
            return $this->redirectToRoute('my_articles');
        }

        $form = $this->createForm(BlogType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->bindRequest($request);
            $this->getEm()->persist($blog);
            $this->getEm()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', $this->getTranslator()->trans(
                    'my_space.success.save_article',
                    [],
                    'validators'
                ));
        }

        return $this->render('front/users/my_space/article_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Dashboard show my articles
     *
     * -------------------- *
     * @Route("/articles", name="my_articles")
     * @Method({"GET"})
     * -------------------- *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myArticlesAction(Request $request)
    {
        /** @var Utilisateur $user */
        $user = $this->getUser();
        if (!$user->getAccesSite()) {
            return $this->redirectToRoute('fos_user_security_logout');
        }
        return $this->render('front/users/my_space/my_articles.html.twig');
    }

    /**
     * Dashboard show my drafts
     *
     * -------------------- *
     * @Route("/brouillons", name="my_drafts")
     * @Method({"GET"})
     * -------------------- *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myDraftsAction(Request $request)
    {
        /** @var Utilisateur $user */
        $user = $this->getUser();
        if (!$user->getAccesSite()) {
            return $this->redirectToRoute('fos_user_security_logout');
        }
        return $this->render('front/users/my_space/my_drafts.html.twig');
    }

    /**
     * Sumbit to review
     *
     * -------------------- *
     * @Route("/soumettre/{slug}/", name="submit_to_review")
     * @Method("GET")
     * -------------------- *
     *
     * @param Request $request
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toReviewAction(Request $request, $slug)
    {
        /** @var Blog $blog */
        $repoBlog   = $this->getEm()->getRepository(Blog::class);
        $blog       = $repoBlog->findOneBySlug($slug);

        $serviceWorkflow = $this->get('app.workflow.blog');
        if (empty($blog)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', $this->getTranslator()->trans(
                    'my_space.error.article_not_found',
                    [],
                    'validators'
                ));
        } elseif (!$serviceWorkflow->canBeReview($blog)) {
            $request->getSession()
                ->getFlashBag()
                ->add('info', $this->getTranslator()->trans(
                    'my_space.info.cant_be_edited',
                    [],
                    'validators'
                ));
        } else {
            $succeed = ($serviceWorkflow->nextIsReopen($blog)?
                $serviceWorkflow->reouvrir($blog):
                $serviceWorkflow->relecture($blog));

            if ($succeed) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', $this->getTranslator()->trans(
                        'my_space.success.send_to_review',
                        [],
                        'validators'
                    ));
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('info', $this->getTranslator()->trans(
                        'my_space.info.cant_be_edited',
                        [],
                        'validators'
                    ));
            }
        }

        return $this->redirectToRoute('my_drafts');
    }
}
