<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\BlogType;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
            $blog->setAffiche(false);
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

        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$form->bindRequest($request);
            $blogAdmin = $this->get('app.admin.blog');
            $this->getEm()->persist($blog);
            $this->getEm()->flush();
            $blogAdmin->createObjectSecurity($blog);
            $request->getSession()
                ->getFlashBag()
                ->add('success', $this->getTranslator()->trans(
                    'my_space.success.save_article',
                    [],
                    'validators'
                ));
            return $this->redirectToRoute('edit_article', ['slug' => $blog->getSlug()]);
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

    /**
     * Dashboard del article
     *
     * -------------------- *
     * @Route("/article/supprimer/{slug}", name="del_article")
     * @Method({"GET", "POST"})
     * -------------------- *
     *
     * @param Request $request
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delBlogAction(Request $request, $slug = null)
    {
        $user = $this->getUser();
        if (!$user->getAccesSite()) {
            return $this->redirectToRoute('fos_user_security_logout');
        }

        if (!is_null($slug)) {
            $blog = $this->getEm()->getRepository(Blog::class)->findOneBySlug($slug);
        }

        $serviceWorkflow = $this->get('app.workflow.blog');

        if (is_null($slug) || (isset($blog) && empty($blog))) {
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
            $this->getEm()->remove($blog);
            $this->getEm()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', $this->getTranslator()->trans(
                    'my_space.success.del_article',
                    [],
                    'validators'
                ));
        }

        return $this->redirectToRoute('my_drafts');
    }

    /**
     * Dashboard my_profil
     *
     * -------------------- *
     * @Route("/mon-profil", name="my_profil")
     * @Method({"GET", "POST"})
     * -------------------- *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profilAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user->getAccesSite()) {
            return $this->redirectToRoute('fos_user_security_logout');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getEm()->persist($user);
            $this->getEm()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', $this->getTranslator()->trans(
                    'my_space.success.save_profil',
                    [],
                    'validators'
                ));
        }

        return $this->render('front/users/my_space/profil_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Dashboard my_account
     *
     * -------------------- *
     * @Route("/mon-compte", name="my_account")
     * @Method({"GET", "POST"})
     * -------------------- *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accountAction(Request $request)
    {
        /** @var Utilisateur $user */
        $user = $this->getUser();
        if (!$user->getAccesSite()) {
            return $this->redirectToRoute('fos_user_security_logout');
        }

        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getEm()->persist($user);
            $this->getEm()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', $this->getTranslator()->trans(
                    'my_space.success.save_password',
                    [],
                    'validators'
                ));
        }

        return $this->render('front/users/my_space/update_password_form.html.twig', ['form' => $form->createView()]);
    }
}
