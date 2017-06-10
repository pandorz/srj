<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Actualite;


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
     * @return array
     */
    protected function getTopEvenements()
    {
        return $this->getEm()
                ->getRepository(Evenement::class)
                ->findBy(
                    [
                        'affiche' => true, 
                        'annule' => false
                    ],
                    ['dateDebut' => 'DESC'],
                    3
                );
    }
    
    /**
     * @return array
     */
    protected function getTopActualites()
    {
        return $this->getEm()
                ->getRepository(Actualite::class)
                ->findBy(
                    [
                        'affiche' => true, 
                        'annule' => false
                    ],
                    ['dateDebut' => 'DESC'],
                    4
                );
    }
}
