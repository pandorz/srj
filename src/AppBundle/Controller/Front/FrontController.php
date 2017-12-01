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

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Atelier;
use AppBundle\Entity\Sortie;

/**
 * Class FrontController
 * @package AppBundle\Controller\Front
 */
class FrontController extends BaseController
{
    const FORMAT_DATE = 'Y-m-d';

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
        $blogs      = $this->getTopBlogs(1);
        $blog       = null;

        if(!empty($blogs) && is_array($blogs) && isset($blogs[0]) && $blogs[0] instanceof Blog) {
            $blog = $blogs[0];
        }

        return $this->render('home.html.twig', [
            'evenements' => $evenements,
            'actualites' => $actualites,
            'dates'      => $dates,
            'blog'       => $blog
        ]);
    }

    /**
     * Newsletter
     *
     * -------------------- *
     * @Route("/add-newsletter", name="add_newsletter")
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsletterAction(Request $request)
    {
        $captcha = true;
        //-- Check Google Recaptcha
        if (hash_equals($this->getEnvironment(), 'prod')) {
            try {
                $this->checkGoogleRecaptcha($request->request->get('g-recaptcha-response'));
            } catch (\Exception $e) {
                if ($e->getCode() == self::EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED) {
                    $request
                        ->getSession()
                        ->getFlashBag()
                        ->add('error',
                            $this->getTranslator()->trans(
                                'general.error.grecaptcha.detected_as_robot',
                                [],
                                'validators'
                            )
                        );
                    $captcha = false;
                }
            }
        }
        //--

        $email = $request->get('newsletter_email');
        if (!empty($email) && $captcha) {
            try {
                $demandeNewsletter = new DemandeNewsletter();
                $demandeNewsletter->setEmail($email);
                $em = $this->getEm();
                $em->persist($demandeNewsletter);
                $em->flush();
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('success', 'Nous avons enregistré votre demande');
            } catch (\Exception $exception) {
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('error', 'Erreur lors de l\'envoi de votre message. Réessayez ultérieument');
            }

        } elseif(empty($email)) {
            $request
                ->getSession()
                ->getFlashBag()
                ->add('error', 'Votre email ne peut pas être vide');
        }

        return $this->redirectToRoute('home');
    }
    
    private function getDatesCalendrier()
    {
        $data       = [];
        $evenements = $this->getEm()
                ->getRepository(Evenement::class)
                ->findAllValidOverOneMonth();

        foreach ($evenements as $evenement) {
            $start = $evenement->getDateDebut();
            $end   = $evenement->getDateFin();
            
            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }
            
            if (!is_null($end)) {
                $end = $end->format(self::FORMAT_DATE);
            }
            
            $data[] = [
                'title' => $evenement->getNom(),
                'start' => $start,
                'end'   => $end
            ];
        }
        
        $ateliers= $this->getEm()
                ->getRepository(Atelier::class)
                ->findAllValidOverOneMonth();
        
        foreach ($ateliers as $atelier) {
            $start = $atelier->getDate();
            
            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }
            
            $data_temp = [
                'title' => $atelier->getNom(),
                'start' => $start
            ];

            if (!empty($atelier->getUrlInscription())) {
                $data_temp['url'] = $atelier->getUrlInscription();
            }
            $data[] = $data_temp;
        }
        
        $sorties = $this->getEm()
                ->getRepository(Sortie::class)
                ->findAllValidOverOneMonth();
        
        foreach ($sorties as $sortie) {           
            $start = $sortie->getDate();
            
            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }

            $data_temp = [
                'title' => $sortie->getNom(),
                'start' => $start
            ];

            if (!empty($sortie->getUrlInscription())) {
                $data_temp['url'] = $sortie->getUrlInscription();
            }
            $data[] = $data_temp;
        }
        
        return $data;
    }
    
    /**
    * Sorties
    *
    * -------------------- *
    * @Route("/sorties/{plus}/", name="sorties", defaults={"plus" = "recent"})
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function sortiesAction(Request $request, $plus)
    {
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $sorties = $this->getTopSorties($limit);
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
        $cours = $this->getEm()->getRepository(Cour::class)->getAffichable();
        return $this->render('cours.html.twig', ['cours' => $cours]);
    }
    
    /**
    * Ateliers
    *
    * -------------------- *
    * @Route("/ateliers/{plus}/", name="ateliers", defaults={"plus" = "recent"})
    * @Method("GET")
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function ateliersAction(Request $request, $plus)
    {
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $ateliers = $this->getTopAteliers($limit);
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
        $bureau         = $this->getEm()->getRepository(Utilisateur::class)->findAllBureau();
        $partenaires    = $this->getEm()->getRepository(Partenaire::class)->findBy([], ['slug' => 'ASC']);
        return $this->render('association.html.twig', ['bureau' => $bureau, 'partenaires' => $partenaires]);
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
}
