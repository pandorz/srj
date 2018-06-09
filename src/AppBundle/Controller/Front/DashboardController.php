<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Cour;
use AppBundle\Entity\DemandeNewsletter;
use AppBundle\Entity\Partenaire;
use AppBundle\Entity\Utilisateur;
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
}
