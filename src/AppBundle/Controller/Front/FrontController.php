<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Cour;
use AppBundle\Entity\DemandeAcces;
use AppBundle\Entity\DemandeNewsletter;
use AppBundle\Entity\Partenaire;
use AppBundle\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    public function indexAction()
    {
        $evenementsOuKouryukai  = $this->getTopEvenementsOuKouruykai(3);
        $actualites             = $this->getTopActualites(4);
        $dates                  = $this->get('app.front_calendar')->getDates();
        $blogs                  = $this->getTopBlogs(1);
        $blog                   = null;

        if (!empty($blogs) && is_array($blogs) && isset($blogs[0]) && $blogs[0] instanceof Blog) {
            $blog = $blogs[0];
        }

        return $this->render('front/home.html.twig', [
            'evenementsOuKouryukai' => $evenementsOuKouryukai,
            'actualites'            => $actualites,
            'dates'                 => $dates,
            'blog'                  => $blog
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsletterAction(Request $request)
    {
        $captcha = true;
        //-- Check Google Recaptcha
        try {
            $this->get('app.recaptcha')->check($request->request->get('g-recaptcha-response'));
        } catch (\Exception $e) {
            if ($e->getCode() == $this->get('app.recaptcha')->getCodeRecaptchaFailed()) {
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add(
                        'error',
                        $this->getTranslator()->trans(
                            'general.error.grecaptcha.detected_as_robot',
                            [],
                            'validators'
                        )
                    );
                $captcha = false;
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
        } elseif (empty($email)) {
            $request
                ->getSession()
                ->getFlashBag()
                ->add('error', 'Votre email ne peut pas être vide');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * Sorties
     *
     * -------------------- *
     * @Route("/sorties/{plus}/", name="sorties", defaults={"plus" = "recent"})
     * @Method("GET")
     * -------------------- *
     *
     * @param $plus
     * @return Response
     */
    public function sortiesAction($plus)
    {
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $sorties = $this->getTopSorties($limit);
        return $this->render('front/sortie/sorties.html.twig', ['sorties' => $sorties]);
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
    public function coursAction()
    {
        $cours = $this->getEm()->getRepository(Cour::class)->getAffichable();
        return $this->render('front/cours/cours.html.twig', ['cours' => $cours]);
    }

    /**
     * Ateliers
     *
     * -------------------- *
     * @Route("/ateliers/{plus}/", name="ateliers", defaults={"plus" = "recent"})
     * @Method("GET")
     * -------------------- *
     *
     * @param $plus
     * @return Response
     */
    public function ateliersAction($plus)
    {
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $ateliers = $this->getTopAteliers($limit);
        return $this->render('front/atelier/ateliers.html.twig', ['ateliers' => $ateliers]);
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
    public function associationAction()
    {
        $bureau         = $this->getEm()->getRepository(Utilisateur::class)->findAllBureau();
        $partenaires    = $this->getEm()->getRepository(Partenaire::class)->findBy([], ['slug' => 'ASC']);
        return $this->render(
            'front/association/association.html.twig',
            [
                'bureau' => $bureau,
                'partenaires' => $partenaires
            ]
        );
    }

    /**
     * Actualites
     *
     * -------------------- *
     * @Route("/actualites/{plus}/", name="actualites", defaults={"plus" = "recent"})
     * @Method("GET")
     * -------------------- *
     *
     * @param $plus
     * @return Response
     */
    public function actualitesAction($plus)
    {
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $actualites =  $this->getTopActualites($limit);

        $blogs                  = $this->getTopBlogs(1);
        $blog                   = null;

        if (!empty($blogs) && is_array($blogs) && isset($blogs[0]) && $blogs[0] instanceof Blog) {
            $blog = $blogs[0];
        }
        
        return $this->render(
            'front/actualite/actualites.html.twig',
            ['actualites' => $actualites, 'blog' => $blog]
        );
    }

    /**
     * Evenements
     *
     * -------------------- *
     * @Route("/evenements/{plus}/", name="evenements", defaults={"plus" = "recent"})
     * @Method("GET")
     * -------------------- *
     *
     * @param $plus
     * @return Response
     */
    public function evenementsAction($plus)
    {
        $limit = 4;
        if (!hash_equals($plus, "recent")) {
            $limit = null;
        }
        $evenementsOuKouryukai = $this->getTopEvenementsOuKouruykai($limit);

        return $this->render(
            'front/evenement/evenements.html.twig',
            ['evenementsOuKouryukai' => $evenementsOuKouryukai]
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
    public function presJapAction()
    {
        return $this->render('front/association/presentation_japonaise.html.twig', []);
    }

    /**
     * FLux rss
     * -------------------- *
     * @Route("/rss", name="flux_rss")
     * @Method("GET")
     * -------------------- *
     *
     * @return Response
     * @throws \Exception
     */
    public function fluxRssAction()
    {
        $articles = $this->getTopBlogs(null);

        $feed = $this->get('eko_feed.feed.manager')->get('article');
        $feed->addFromArray($articles);

        return new Response($feed->render('rss'));
    }

    /**
     * Association
     *
     * -------------------- *
     * @Route("/mentions-legales", name="mentions_legales")
     * @Method("GET")
     * -------------------- *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mentionsLegalesAction()
    {
        return $this->render('front/mentions_legales/mentions.html.twig');
    }

    /**
     * Newsletter
     *
     * -------------------- *
     * @Route("/get-an-access", name="ask_account")
     * @Method("POST")
     * -------------------- *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function askAccountAction(Request $request)
    {
        $memberNumber = $request->get('memberNumber');
        if (!empty($memberNumber)) {
            if (!preg_match('`^[[:digit:]]+$`', $memberNumber)) {
                return new JsonResponse($this->getTranslator()->trans('ask_account.error.nan'), Response::HTTP_BAD_REQUEST);
            }

            try {
                /** @var Utilisateur $user */
                $user = $this->getEm()->getRepository(Utilisateur::class)->findOneByMembreNumero($memberNumber);

                if (empty($user) || $user->getLocked() || !$user->getAccesSite() || !$user->isEnabled()) {

                    // Si une demande n'est pas déjà en cours
                    $demandeAccount = $this->getEm()->getRepository(DemandeAcces::class)->findOneByNumeroMembre($memberNumber);
                    if (!empty($demandeAccount)) {
                        return new JsonResponse($this->getTranslator()->trans('ask_account.error.pending'));
                    }

                    $demandeAccount = new DemandeAcces();
                    $demandeAccount->setNumeroMembre($memberNumber);
                    $this->getEm()->persist($demandeAccount);
                    $this->getEm()->flush();

                    return new JsonResponse($this->getTranslator()->trans('ask_account.success'));
                } else {
                    return new JsonResponse($this->getTranslator()->trans('ask_account.error.has_access'));
                }
            } catch (\Exception $exception) {
                return new JsonResponse($this->getTranslator()->trans('ask_account.error.server'), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } elseif (empty($email)) {
            return new JsonResponse($this->getTranslator()->trans('ask_account.error.empty'), Response::HTTP_BAD_REQUEST);
        }
    }
}
