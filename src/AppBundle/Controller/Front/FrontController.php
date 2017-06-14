<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\Form\FormError;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Actualite;
use AppBundle\Entity\Atelier;
use AppBundle\Entity\Sortie;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

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
    * @Method({"GET", "POST"})
    * -------------------- *
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function contactAction(Request $request)
    {
        $defaultContact = [];
        $form = $this->createFormBuilder($defaultContact)
            ->add(
                    'nom', 
                    TextType::class, 
                    [
                        'required' => true, 
                        'label_attr' => [ 'class' => 'u-hiddenVisually'],
                        'attr' => ['class' => 'fld', 'placeholder' => '*Nom'],
                        'label' => 'Nom'
                    ]
                )
            ->add(
                    'prenom',
                    TextType::class,
                    [
                        'required' => true,
                        'label_attr' => [ 'class' => 'u-hiddenVisually'],
                        'attr' => ['class' => 'fld', 'placeholder' => '*Prenom'],
                        'label' => 'Prenom'
                    ]
                )
            ->add(
                    'objet', 
                    TextType::class, 
                    [
                        'required' => true,
                        'label_attr' => [ 'class' => 'u-hiddenVisually'],
                        'attr' => [
                            'class' => 'fld', 
                            'placeholder' => '*Objet de votre demande'
                        ],
                        'label' => 'Sujet'
                    ]
                )
            ->add(
                    'email',
                    EmailType::class, 
                    [
                        'required' => true,
                        'label_attr' => [ 'class' => 'u-hiddenVisually'],
                        'attr' => [
                            'class' => 'fld',
                            'placeholder' => '*Votre email'
                        ],
                        'label' => 'Email'
                    ]
                )    
            ->add(
                    'message', 
                    TextareaType::class, 
                    [
                        'required' => true,
                        'label_attr' => [ 'class' => 'fldLabel'],
                        'attr' => [
                            'class' => 'fld',
                            'placeholder' => 'Bonjour,',
                            'rows' => 8
                        ],
                        'label' => 'Votre message'
                    ]
                )    
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //-- Check Google Recaptcha
            try {
                $this->checkGoogleRecaptcha($request->request->get('g-recaptcha-response'));
            } catch (\Exception $e) {
                if ($e->getCode() == self::EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED) {
                    $form->addError(
                        new FormError(
                            $this->getTranslator()->trans(
                                'general.error.grecaptcha.detected_as_robot',
                                [],
                                'validators'
                            )
                        )
                    );
                } else {
                    $form->addError(
                        new FormError(
                            $this->getTranslator()->trans(
                                'general.error.grecaptcha.error_on_verify',
                                [],
                                'validators'
                            )
                        )
                    );
                };
            }
            //--
            if ($form->isValid()) {
                $data = $form->getData();
                // TODO : Send mail
                $this->sendMail(
                    $this->getTranslator()->trans('contact.mail.sujet'),
                    'contact',
                    null,
                    null,
                    [
                        'title'     => $this->getTranslator()->trans('contact.mail.titre'),
                        'subtitle'  => $this->getTranslator()->trans('contact.mail.soustitre'),
                        'data'      => $data
                    ]
                );
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('success', 'Votre message a été envoyé');
            }
            $request
                ->getSession()
                ->getFlashBag()
                ->add('error', 'Erreur lors de l\'envoi de votre message');
        }
        return $this->render('contact.html.twig', ['form' => $form->createView()]);
    }
}
