<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Cour;
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
            new \Twig_SimpleFunction('liste_cours_nav', array($this, 'getNavLinks')),
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
     * @return Parametre
     */
    private function getParamBySlug($slug)
    {
        return $this->entityManager
            ->getRepository(Parametre::class)
            ->findOneBy(['slug' => $slug]);
    }

    /**
     * @return array
     */
    public function getNavLinks()
    {
        $data = [];
        $cours = $this->entityManager->getRepository(Cour::class)->getAffichable();

        if (!empty($cours)) {
            foreach ($cours as $cour) {
                $data[]= ['titre' => $cour->getTitreNav(), 'ancre' => $cour->getAncre()];
            }
        }

        return $data;
    }
}
