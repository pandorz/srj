<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Cour;
use AppBundle\Entity\Parametre;
use AppBundle\Entity\Utilisateur;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManager;
use Sonata\MediaBundle\Provider\ImageProvider;

class TwigHelpers extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ImageProvider
     */
    private $providerImage;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, ImageProvider $providerImage)
    {
        $this->entityManager = $entityManager;
        $this->providerImage = $providerImage;
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
            new \Twig_SimpleFunction('get_footer_blog', array($this, 'getFooterBlog')),
            new \Twig_SimpleFunction('get_image_profil', array($this, 'getImageProfil')),
            new \Twig_SimpleFunction('get_facebook_id', array($this, 'getFacebookId')),
            new \Twig_SimpleFunction('get_facebook_page_id', array($this, 'getFacebookPageId')),
            new \Twig_SimpleFunction('is_actif_facebook_messenger', array($this, 'isActifFacebookMessenger')),
        );
    }

    public function cropEnteteTexte($chaine)
    {
        if (strlen($chaine)>99) {
            return substr($chaine, 0, strpos($chaine, "</p>"));
        }

        return $chaine;
    }

    public function getCorpsTexte($chaine)
    {
        if (strlen($chaine)<=99) {
            return '';
        }

        return ltrim(str_replace($this->cropEnteteTexte($chaine), '', $chaine), "</p>");
    }
    
    private function returnParametreValue($parametre)
    {
        if (!is_null($parametre) && !is_null($parametre->getValue())) {
            return $parametre->getValue();
        }
        return '';
    }

    public function getFacebookId()
    {
        $parametre = $this->getParamBySlug('facebook-app-id');
        return $this->returnParametreValue($parametre);
    }

    public function getFacebookPageId()
    {
        $parametre = $this->getParamBySlug('facebook-page-id');
        return $this->returnParametreValue($parametre);
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

    public function isActifFacebookMessenger()
    {
        $parametre = $this->getParamBySlug('affichage-facebook-messenger-app');

        return $this->returnParametreValue($parametre) == "1";
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

    public function getImageProfil(int $idUtilisateur)
    {
        $result = $this->entityManager->getRepository(Utilisateur::class)->findMedia($idUtilisateur);
        if (!empty($result) && isset($result[0])) {
            /** @var Media $media */
            $media = $result[0];
            $media->setContext('image');
            $format = $this->providerImage->getFormatName($media, 'big');
            return str_replace('.jpg','.jpeg', $this->providerImage->generatePublicUrl($media, $format));
        }
        return null;
    }
}
