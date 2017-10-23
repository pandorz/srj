<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Blog;
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
            new \Twig_SimpleFunction('lien_cours_yoga', array($this, 'getLienCoursYoga')),
            new \Twig_SimpleFunction('lien_cours_japonais_enfant', array($this, 'getLienCoursJaponaisEnfant')),
            new \Twig_SimpleFunction('lien_cours_calligraphie', array($this, 'getLienCoursCalligraphie')),
            new \Twig_SimpleFunction('lien_cours_the', array($this, 'getLienCoursThe')),
            new \Twig_SimpleFunction('lien_calendrier_cours_japonais', array($this, 'getLienCalendrierCoursJaponais')),
            new \Twig_SimpleFunction('lien_calendrier_cours_japonais_enfant', array($this, 'getLienCalendrierCoursJaponaisEnfant')),
            new \Twig_SimpleFunction('lien_calendrier_cours_calligraphie', array($this, 'getLienCalendrierCoursCalligraphie')),
            new \Twig_SimpleFunction('lien_calendrier_cours_the', array($this, 'getLienCalendrierCoursThe')),
            new \Twig_SimpleFunction('lien_calendrier_cours_yoga', array($this, 'getLienCalendrierCoursYoga')),
            new \Twig_SimpleFunction('is_actif_blog', array($this, 'isActifBlog')),
            new \Twig_SimpleFunction('crop_entete_texte', array($this, 'cropEnteteTexte')),
            new \Twig_SimpleFunction('get_corps_texte', array($this, 'getCorpsTexte')),
            new \Twig_SimpleFunction('get_footer_blog', array($this, 'getFooterBlog'))
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
        $parametre = $this->getParamBySlug('lien-adhesion-membre');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienAdhesionJaponais()
    {
        $parametre =$this->getParamBySlug('lien-adhesion-membre-japonais');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursJaponais()
    {
        $parametre = $this->getParamBySlug('lien-inscription-cours-japonais');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursYoga()
    {
        $parametre =$this->getParamBySlug('lien-inscription-cours-yoga');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursJaponaisEnfant()
    {
        $parametre = $this->getParamBySlug('lien-inscription-cours-enfant');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursCalligraphie()
    {
        $parametre = $this->getParamBySlug('lien-inscription-cours-calligraphie');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCoursThe()
    {
        $parametre = $this->getParamBySlug('lien-inscription-cours-ceremonie-du-the');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursJaponais()
    {
        $parametre = $this->getParamBySlug('lien-pdf-calendrier-cours-japonais');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursJaponaisEnfant()
    {
        $parametre = $this->getParamBySlug('lien-pdf-calendrier-cours-enfants');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursCalligraphie()
    {
        $parametre = $this->getParamBySlug('lien-pdf-calendrier-cours-calligraphie');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursThe()
    {
        $parametre = $this->getParamBySlug('lien-pdf-calendrier-ceremonie-du-the');
        return $this->returnParametreValue($parametre);
    }
    
    public function getLienCalendrierCoursYoga()
    {
        $parametre = $this->getParamBySlug('lien-pdf-calendrier-cours-yoga');
        return $this->returnParametreValue($parametre);
    }

    public function isActifBlog()
    {
        $parametre = $this->getParamBySlug('affichage-blog-public');

        return $this->returnParametreValue($parametre) == "1";

    }

    public function getFooterBlog()
    {
        $blogs = $this->entityManager
            ->getRepository(Blog::class)
            ->getTop(4);

        return $blogs;
    }
    
    /**
     * @param string $slug
     * return Parametre
     */
    private function getParamBySlug($slug)
    {
        return $this->entityManager
            ->getRepository(Parametre::class)
            ->findOneBy(['slug' => $slug]);
    }
}
