<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Parametre;
use Doctrine\ORM\EntityManager;

class TwigHelpers extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('lien_adhesion', array($this, 'getLienAdhesion')),
            new \Twig_SimpleFunction('lien_adhesion_japonais', array($this, 'getLienAdhesionJaponais')),
            new \Twig_SimpleFunction('lien_cours_japonais', array($this, 'getLienCoursJaponais')),
            new \Twig_SimpleFunction('lien_cours_japonais_enfant', array($this, 'getLienCoursJaponaisEnfant')),
            new \Twig_SimpleFunction('lien_cours_calligraphie', array($this, 'getLienCoursCalligraphie')),
            new \Twig_SimpleFunction('lien_cours_the', array($this, 'getLienCoursThe')),
            new \Twig_SimpleFunction('lien_calendrier_cours_japonais', array($this, 'getLienCalendrierCoursJaponais')),
            new \Twig_SimpleFunction('lien_calendrier_cours_japonais_enfant', array($this, 'getLienCalendrierCoursJaponaisEnfant')),
            new \Twig_SimpleFunction('lien_calendrier_cours_calligraphie', array($this, 'getLienCalendrierCoursCalligraphie')),
            new \Twig_SimpleFunction('lien_calendrier_cours_the', array($this, 'getLienCalendrierCoursThe')),
            new \Twig_SimpleFunction('is_actif_blog', array($this, 'isActifBlog')),
            new \Twig_SimpleFunction('crop_entete_texte', array($this, 'cropEnteteTexte')),
            new \Twig_SimpleFunction('get_corps_texte', array($this, 'getCorpsTexte'))
        );
    }

    public function cropEnteteTexte($chaine)
    {
        if (strlen($chaine)>99) {
            return substr($chaine,0, strpos($chaine, "</p>"));
        }

        return $chaine;
    }

    public function getCorpsTexte($chaine)
    {
        if (strlen($chaine)<=99) {
            return '';
        }

        return str_replace($this->cropEnteteTexte($chaine), '', $chaine);
    }
    
    private function returnParametreValue($parametre)
    {
        if (!is_null($parametre) && !is_null($parametre->getValue())) {
            return $parametre->getValue();
        }
        return '';
    }


    public function getLienAdhesion()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-adhesion-membre']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienAdhesionJaponais()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-adhesion-membre-japonais']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursJaponais()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-inscription-cours-japonais']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursJaponaisEnfant()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-inscription-cours-enfant']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursCalligraphie()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-inscription-cours-calligraphie']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursThe()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-inscription-cours-ceremonie-du-the']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursJaponais()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-pdf-calendrier-cours-japonais']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursJaponaisEnfant()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-pdf-calendrier-cours-enfants']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursCalligraphie()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-pdf-calendrier-cours-calligraphie']);
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursThe()
    {
        $parametre = $this->entityManager
                ->getRepository(Parametre::class)
                ->findOneBy(['slug' => 'lien-pdf-calendrier-ceremonie-du-the']);
        return $this->returnParametreValue($parametre);
    }

    public function isActifBlog()
    {
        $parametre = $this->entityManager
            ->getRepository(Parametre::class)
            ->findOneBy(['slug' => 'affichage-blog-public']);

        if (!empty($parametre) && $parametre == "1") {
            return true;
        }

        return false;
    }
}
