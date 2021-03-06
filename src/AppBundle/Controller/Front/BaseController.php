<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Kouryukai;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Actualite;
use AppBundle\Entity\Atelier;
use AppBundle\Entity\Sortie;
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
}
