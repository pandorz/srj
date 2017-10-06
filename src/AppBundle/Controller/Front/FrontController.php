<?php

namespace AppBundle\Controller\Front;

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
        $blog       = $this->getTopBlogs(1);

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
                } else {
                    $request
                        ->getSession()
                        ->getFlashBag()
                        ->add('error',
                            $this->getTranslator()->trans(
                                'general.error.grecaptcha.error_on_verify',
                                [],
                                'validators'
                            )
                        );
                    $captcha = false;
                }
            }
        }
        //--
        $email = '';
        if (!empty($email) && $captcha) {
            $data = ['email' => $email];

            $retour_mail = $this->sendMail(
                $this->getTranslator()->trans('newsletter.mail.sujet'),
                'newsletter',
                null,
                $data['email'],
                null,
                [
                    'title'     => $this->getTranslator()->trans('newsletter.mail.titre'),
                    'subtitle'  => $this->getTranslator()->trans('newsletter.mail.soustitre'),
                    'data'      => $data
                ]
            );

            if ($retour_mail) {
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('success', 'Nous avone enregistré votre demande');
            } else {
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('error', 'Erreur lors de l\'envoi de votre message. Réessayez ultérieument');
            }

        } else {
            $request
                ->getSession()
                ->getFlashBag()
                ->add('error', 'Votre email ne peut pas être vide');
        }
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
        
        $actualites= $this->getEm()
                ->getRepository(Actualite::class)
                ->findAllValidOverOneMonth();
        
        foreach ($actualites as $actualite) {
            $start = $actualite->getDateDebut();
            $end   = $actualite->getDateFin();
            
            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }
            
            if (!is_null($end)) {
                $end = $end->format(self::FORMAT_DATE);
            }
            
            $data[] = [
                'title' => $actualite->getNom(),
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
            
            $data[] = [
                'title' => $atelier->getNom(),
                'start' => $start
            ];
        }
        
        $sorties = $this->getEm()
                ->getRepository(Sortie::class)
                ->findAllValidOverOneMonth();
        
        foreach ($sorties as $sortie) {           
            $start = $sortie->getDate();
            
            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }
            $data[] = [
                'title' => $sortie->getNom(),
                'start' => $start
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
}
