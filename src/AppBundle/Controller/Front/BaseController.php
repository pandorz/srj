<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class BaseController
 * @package AppBundle\Controller\Front
 */
class BaseController extends Controller
{
    private $translator;
    private $em;
    
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function getEm()
    {
        if (!is_null($this->em)) {
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
}
