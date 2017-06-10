<?php

namespace AppBundle\Controller\Front;

use AppBundle\Controller\Front\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Actualite;
use AppBundle\Entity\Atelier;
use AppBundle\Entity\Sortie;

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
        $dates      = $this->getDatesCalendrier();
        
        return $this->render('home.html.twig', [
            'evenements' => $evenements,
            'actualites' => $actualites,
            'dates'      => $dates
        ]);
    }
    
    private function getDatesCalendrier()
    {
        $data       = [];
        $evenements = $this->getEm()
                ->getRepository(Evenement::class)
                ->findAllValidOverOneMonth();
        
        foreach ($evenements as $evenement) {
            $data[] = [
                'title' => $evenement->getNom(),
                'start' => $evenement->getDateDebut(),
                'end'   => $evenement->getDateFin()
            ];
        }
        
        $actualites= $this->getEm()
                ->getRepository(Actualite::class)
                ->findAllValidOverOneMonth();
        
        foreach ($actualites as $actualite) {
            $data[] = [
                'title' => $actualite->getNom(),
                'start' => $actualite->getDateDebut(),
                'end'   => $actualite->getDateFin()
            ];
        }
        
        $ateliers= $this->getEm()
                ->getRepository(Atelier::class)
                ->findAllValidOverOneMonth();
        
        foreach ($ateliers as $atelier) {
            $data[] = [
                'title' => $atelier->getNom(),
                'start' => $atelier->getDate()
            ];
        }
        
        $sorties = $this->getEm()
                ->getRepository(Sortie::class)
                ->findAllValidOverOneMonth();
        
        foreach ($sorties as $sortie) {
            $data[] = [
                'title' => $sortie->getNom(),
                'start' => $sortie->getDate()
            ];
        }
        
        return $data;
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
        $sorties = $this->getTopSorties(6);
        return $this->render('sorties.html.twig', ['sorties' => $sorties]);
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
        $ateliers = $this->getTopAteliers(6);
        return $this->render('ateliers.html.twig', ['ateliers' => $ateliers]);
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
