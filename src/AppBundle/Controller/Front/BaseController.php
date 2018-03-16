<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Kouryukai;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Actualite;
use AppBundle\Entity\Atelier;
use AppBundle\Entity\Sortie;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Symfony\Bridge\Monolog\Logger;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\IdentityTranslator;

/**
 * Class BaseController
 * @package AppBundle\Controller\Front
 */
class BaseController extends Controller
{
    /**
     * Code of captach fail
     */
    const EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED = 100;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var IdentityTranslator
     */
    private $translator;

    /**
     * @var string
     */
    private $webDir;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Logger
     */
    private $logger;
    
    /**
     * @return ObjectManager
     */
    public function getEm()
    {
        if (is_null($this->em)) {
            $this->em = $this->getDoctrine()->getManager();
        }
        return $this->em;
    }

    /**
     * Get web dir real path
     *
     * @return string
     */
    public function getWebDir()
    {
        if (!isset($this->webDir)) {
            $this->webDir = realpath($this->getParameter('web_path'));
        }

        return $this->webDir;
    }

    /**
     * Get the kernel env
     *
     * @return string
     */
    public function getEnvironment()
    {
        if (!isset($this->environment)) {
            $this->environment = $this->get('kernel')->getEnvironment();
        }

        return $this->environment;
    }

    /**
     * Get Monolog logger
     *
     * @return Logger
     */
    public function getLogger()
    {
        if (!isset($this->logger)) {
            $this->logger = $this->get('logger');
        }

        return $this->logger;
    }

    /**
     * Get translation service
     */
    public function getTranslator()
    {
        if (is_null($this->translator)) {
            $this->translator = $this->get('translator');
        }
        return $this->translator;
    }

    /**
     * Send a Email with SwiftMailer
     *
     * @param string $subject
     * @param string $template
     * @param string $to
     * @param null $bcc
     * @param array $data
     * @param array $attachments
     *
     * @return bool
     */
    public function sendMail($subject, $template, $to = null, $replyTo = null, $bcc = null, $data =[], $attachments =[])
    {
        try {
            $noReplyEmail       = $this->getParameter('no-reply_email');


            $noReplyEmailTitle  = $this->getParameter('no-reply_name');


            $from = ([$noReplyEmail => $noReplyEmailTitle]);

            $mailDefault = $this->getParameter('mailer_admin');

            $to = (empty($to) ? $mailDefault : $to);

            $webDir   = $this->getWebDir().'/';
            $mediaDir = 'medias/img/';
            $logoFile = 'logo-rouen-japon.png';

            //-- Initialisation de SwiftMailer et des variables de base
            $message          = \Swift_Message::newInstance();
            $data['logo_cid'] = $message->embed(\Swift_Image::fromPath($webDir.$mediaDir.$logoFile));
            //--

            $cssToInlineStyles = new CssToInlineStyles();

            $htmlMail = $this->renderView(
                'emails/'.$template.'.html.twig',
                $data
            );

            $cssMail = file_get_contents(
                $webDir.$this->get('twig_asset_version_extension')
                    ->getAssetVersion('css/mail.css')
            );

            $htmlMail = $cssToInlineStyles->convert($htmlMail, $cssMail);

            $message
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody(
                    $htmlMail,
                    'text/html'
                );

            if (!is_null($replyTo)) {
                $message->setReplyTo($replyTo);
            }

            if (!is_null($bcc) && !empty($bcc)) {
                $message->setBcc($bcc);
            }

            $message
                ->addPart(
                    $this->renderView(
                        'emails/'.$template.'.txt.twig',
                        $data
                    ),
                    'text/plain'
                );

            //Attachments Manager
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $message->attach(\Swift_Attachment::newInstance(
                        file_get_contents($attachment['path']),
                        $attachment['name'],
                        $attachment['mime_type']
                    ));
                }
            }

            $this->get('mailer')->send($message);
        } catch (\Exception $e) {
            $this->getLogger()->addCritical(
                "Can't send email [".$subject."] from 
                [".json_encode($from)."] to [".json_encode($to)."] : "
                .$e->getMessage(),
                ['exception' => $e]
            );

            return false;
        }

        return true;
    }
    
    /**
     * @param int $limit
     * @return array
     */
    protected function getTopEvenements($limit)
    {
        $evenements = [];
        //-- Prochainement
        $prochainEvenement = $this->getEm()
                ->getRepository(Evenement::class)
                ->findProchain();
        if (!is_null($prochainEvenement)) {
            if (is_array($prochainEvenement) && count($prochainEvenement)>0) {
                $prochainEvenement = $prochainEvenement[0];
            }
            if (!empty($prochainEvenement)) {
                $evenements = [$prochainEvenement];
                $limit--;
            }
        }

        //--

        //-- Dernierement
        $dernierement = $this->getEm()
                ->getRepository(Evenement::class)
                ->findDernier($limit);

        if (!is_null($dernierement)) {
            if (!is_array($dernierement) && !empty($dernierement)) {
                $evenements[] = $dernierement;
            } else {
                foreach ($dernierement as $evenement) {
                    if (!empty($dernierement)) {
                        $evenements[] = $evenement;
                    }
                }
            }
        }
        //--
        
        return $evenements;
    }

    /**
     * @param int $limit
     * @return array
     */
    protected function getTopKouryukai($limit)
    {
        $kouryukai = [];
        //-- Prochainement
        $prochainKouryukai = $this->getEm()
            ->getRepository(Kouryukai::class)
            ->findProchain();
        if (!is_null($prochainKouryukai)) {
            if (is_array($prochainKouryukai) && count($prochainKouryukai)>0) {
                $prochainKouryukai = $prochainKouryukai[0];
            }
            if (!empty($prochainKouryukai)) {
                $kouryukai = [$prochainKouryukai];
                $limit--;
            }
        }

        //--

        //-- Dernierement
        $dernierement = $this->getEm()
            ->getRepository(Kouryukai::class)
            ->findDernier($limit);

        if (!is_null($dernierement)) {
            if (!is_array($dernierement) && !empty($dernierement)) {
                $kouryukai[] = $dernierement;
            } else {
                foreach ($dernierement as $k) {
                    if (!empty($dernierement)) {
                        $kouryukai[] = $k;
                    }
                }
            }
        }
        //--

        return $kouryukai;
    }

    /**
     * @param int $limit
     * @return array
     */
    protected function getTopEvenementsOuKouruykai($limit)
    {
        $evenements = $this->getTopEvenements($limit);
        $kouryukai  = $this->getTopKouryukai($limit);

        $tabTimestamp = [];

        /** @var Evenement $evenement */
        foreach ($evenements as $evenement) {
            $timestamp = $evenement->getDateDebut()->getTimestamp();
            while (isset($tabTimestamp[$timestamp])) {
                $timestamp++;
            }
            $tabTimestamp[$timestamp] = $evenement;
        }

        /** @var Kouryukai $k */
        foreach ($kouryukai as $k) {
            $timestamp = $k->getDate()->getTimestamp();
            while (isset($tabTimestamp[$timestamp])) {
                $timestamp++;
            }
            $tabTimestamp[$timestamp] = $k;
        }

        krsort($tabTimestamp);

        $tabElements = [];
        // Ne garder qu'un seul element dans le futur
        // N'avoir qu'un tableau de la taille "limit" max
        $cpt = 0;
        $now = new \DateTime();
        foreach ($tabTimestamp as $element) {
            if (is_null($limit) || $cpt < $limit) {
                $dateElement = ($element instanceof Kouryukai ? $element->getDate() : $element->getDateDebut());
                if ($dateElement >= $now && isset($tabElements[0])) {
                    $tabElements[0] = $element;
                } else {
                    $tabElements[] = $element;
                    $cpt++;
                }
            }
        }

        return $tabElements;
    }
    
    /**
     * @param int $limit
     * @return array
     */
    protected function getTopActualites($limit)
    {
        return $this->getEm()
                ->getRepository(Actualite::class)
                ->getTop($limit);
    }
    
    /**
     * @param int $limit
     * @return array
     */
    protected function getTopAteliers($limit)
    {
        return $this->getEm()
                ->getRepository(Atelier::class)
                ->getTop($limit);
    }
    
    /**
     * @param int $limit
     * @return array
     */
    protected function getTopSorties($limit)
    {
        return $this->getEm()
                ->getRepository(Sortie::class)
                ->getTop($limit);
    }

    /**
     * @param int $limit
     * @return array
     */
    protected function getTopBlogs($limit)
    {
        return $this->getEm()
            ->getRepository(Blog::class)
            ->getTop($limit);
    }
    
     /**
     * Check Google recaptcha
     *
     * @param $response
     *
     * @return bool
     * @throws \Exception
     */
    protected function checkGoogleRecaptcha($response)
    {
        if (empty($response)) {
            throw new \Exception('Error on recaptcha response');
        }

        $params = array('secret'    => $this->getParameter('google_recaptcha_secret_token'),
                        'response'  => $response);

        $url = $this->getParameter('google_recaptcha_url').'?'. http_build_query($params);


        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt(
                $curl,
                CURLOPT_USERAGENT,
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:52.0) Gecko/20100101 Firefox/52.0'
            );

            $response = curl_exec($curl);
        } else {
            $response = file_get_contents($url);
        }

        $json = json_decode($response);

        if (empty($json)) {
            throw new \Exception('Error on recaptcha verify curl');
        }

        if ($json->success == false) {
            throw new \Exception('Detected as robot', self::EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED);
        }

        return true;
    }
}
