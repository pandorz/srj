<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Actualite;
use AppBundle\Entity\Atelier;
use AppBundle\Entity\Sortie;


/**
 * Class BaseController
 * @package AppBundle\Controller\Front
 */
class BaseController extends Controller
{
    private $translator;
    /*
     * @var ObjectManager
     */
    private $em;
    
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getEm()
    {
        if (is_null($this->em)) {
            $this->em = $this->getDoctrine()->getManager();
        }
        return $this->em;
    }

    /**
     * Get translation service
     */
    public function getTranslator()
    {
        if (!is_null($this->translator)) {
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
        return $this->getEm()
                ->getRepository(Evenement::class)
                ->findBy(
                    [
                        'affiche' => true, 
                        'annule' => false
                    ],
                    ['dateDebut' => 'DESC'],
                    $limit
                );
    }
    
    /**
     * @param int $limit
     * @return type
     */
    protected function getTopActualites($limit)
    {
        return $this->getEm()
                ->getRepository(Actualite::class)
                ->findBy(
                    [
                        'affiche' => true, 
                        'annule' => false
                    ],
                    ['dateDebut' => 'DESC'],
                    $limit
                );
    }
    
    /**
     * @param int $limit
     * @return type
     */
    protected function getTopAteliers($limit)
    {
        return $this->getEm()
                ->getRepository(Atelier::class)
                ->findBy(
                    [
                        'affiche' => true, 
                        'annule' => false
                    ],
                    ['date' => 'DESC'],
                    $limit
                );
    }
    
    /**
     * @param int $limit
     * @return type
     */
    protected function getTopSorties($limit)
    {
        return $this->getEm()
                ->getRepository(Sortie::class)
                ->findBy(
                    [
                        'affiche' => true, 
                        'annule' => false
                    ],
                    ['date' => 'DESC'],
                    $limit
                );
    }
}
