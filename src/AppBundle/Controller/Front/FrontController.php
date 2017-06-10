<?php

namespace AppBundle\Controller\Front;

use AppBundle\Controller\Front\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontController
 * @package AppBundle\Controller\Front
 */
class FrontController extends BaseController
{
    /**
    * Accueil
    *
    * -------------------- *
    * @Route("/", name="home")
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function indexAction(Request $request)
    {        
        $evenements = $this->getTopEvenements(3);
        $actualites = $this->getTopActualites(4);
        
        return $this->render('home.html.twig', [
            'evenements' => $evenements,
            'actualites' => $actualites
        ]);
    }
    
    /**
    * Sorties
    *
    * -------------------- *
    * @Route("/sorties", name="sorties")
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function sortiesAction(Request $request)
    {        
        return $this->render('sorties.html.twig', []);
    }
    
    /**
    * Cours
    *
    * -------------------- *
    * @Route("/cours", name="cours")
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function coursAction(Request $request)
    {        
        return $this->render('cours.html.twig', []);
    }
    
    /**
    * Ateliers
    *
    * -------------------- *
    * @Route("/ateliers", name="ateliers")
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function ateliersAction(Request $request)
    {        
        return $this->render('ateliers.html.twig', []);
    }
    
    /**
    * Association
    *
    * -------------------- *
    * @Route("/association", name="association")
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function associationAction(Request $request)
    {        
        return $this->render('association.html.twig', []);
    }
    
    /**
    * Actualites
    *
    * -------------------- *
    * @Route("/actualites/{plus}/", name="actualites", defaults={"plus" = "recent"})
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function actualitesAction(Request $request, $plus)
    {   
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $actualites =  $this->getTopActualites($limit);
        
        return $this->render(
                'actualites.html.twig',
                ['actualites' => $actualites]
                );
    }
    
    /**
    * Evenements
    *
    * -------------------- *
    * @Route("/evenements", name="evenements", defaults={"plus" = "recent"})
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function evenementsAction(Request $request, $plus)
    {        
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $evenements = $this->getTopEvenements($limit);
        return $this->render(
            'evenements.html.twig',
            ['evenements' => $evenements]
        );
    }
    
    /**
    * Presentation japonaise
    *
    * -------------------- *
    * @Route("/kyokai", name="presentation_japonaise")
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function presJapAction(Request $request)
    {        
        return $this->render('presentation_japonaise.html.twig', []);
    }
    
    /**
    * Contact
    *
    * -------------------- *
    * @Route("/contact", name="contact")
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function contactAction(Request $request)
    {        
        return $this->render('contact.html.twig', []);
    }
}
