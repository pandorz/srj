<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Cour;
use AppBundle\Entity\Utilisateur;
use AppBundle\Service\Parameter;
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
     * @var Parameter
     */
    private $parameter;

    /**
     * @param EntityManager $entityManager
     * @param ImageProvider $providerImage
     * @param Parameter $parameter
     */
    public function __construct(EntityManager $entityManager, ImageProvider $providerImage, Parameter $parameter)
    {
        $this->entityManager = $entityManager;
        $this->providerImage = $providerImage;
        $this->parameter     = $parameter;
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
            new \Twig_SimpleFunction('lien_facebook', array($this, 'getLienFacebook')),
            new \Twig_SimpleFunction('lien_twitter', array($this, 'getLienTwitter')),
            new \Twig_SimpleFunction('adresse_postal', array($this, 'getAdressePostale')),
            new \Twig_SimpleFunction('adresse_cours', array($this, 'getAdresseCours')),
            new \Twig_SimpleFunction('telephone', array($this, 'getTelephone')),
            new \Twig_SimpleFunction('montant_cotisation', array($this, 'getMontantCotisation'))
        );
    }

    /**
     * @param $chaine
     * @return bool|string
     */
    public function cropEnteteTexte($chaine)
    {
        if (strlen($chaine)>99) {
            return substr($chaine, 0, strpos($chaine, "</p>"));
        }

        return $chaine;
    }

    /**
     * @param $chaine
     * @return string
     */
    public function getCorpsTexte($chaine)
    {
        if (strlen($chaine)<=99) {
            return '';
        }

        return ltrim(str_replace($this->cropEnteteTexte($chaine), '', $chaine), "</p>");
    }

    /**
     * @return string
     */
    public function getLienFacebook()
    {
        return $this->parameter->getParamBySlug('lien-page-facebook');
    }

    /**
     * @return string
     */
    public function getLienTwitter()
    {
        return $this->parameter->getParamBySlug('lien-page-twitter');
    }

    /**
     * @return string
     */
    public function getAdressePostale()
    {
        return $this->parameter->getParamBySlug('adresse');
    }

    /**
     * @return string
     */
    public function getAdresseCours()
    {
        return $this->parameter->getParamBySlug('adresse-cours');
    }

    /**
     * @return string
     */
    public function getMontantCotisation()
    {
        return $this->parameter->getParamBySlug('montant-cotisation');
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->parameter->getParamBySlug('telephone');
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->parameter->getParamBySlug('facebook-app-id');
    }

    /**
     * @return string
     */
    public function getFacebookPageId()
    {
        return $this->parameter->getParamBySlug('facebook-page-id');
    }

    /**
     * @return string
     */
    public function getLienAdhesion()
    {
        return $this->parameter->getParamBySlug('lien-adhesion-membre');
    }

    /**
     * @return string
     */
    public function getLienAdhesionJaponais()
    {
        return $this->parameter->getParamBySlug('lien-adhesion-membre-japonais');
    }

    /**
     * @return bool
     */
    public function isActifFacebookMessenger()
    {
        return $this->parameter->getParamBySlug('affichage-facebook-messenger-app') == "1";
    }

    /**
     * @return bool
     */
    public function isActifBlog()
    {
        return $this->parameter->getParamBySlug('affichage-blog-public') == "1";
    }

    /**
     * @return mixed
     */
    public function getFooterBlog()
    {
        $blogs = $this->entityManager
            ->getRepository(Blog::class)
            ->getTop(4);

        return $blogs;
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

    /**
     * @param int $idUtilisateur
     * @return mixed|null
     */
    public function getImageProfil(int $idUtilisateur)
    {
        $result = $this->entityManager->getRepository(Utilisateur::class)->findMedia($idUtilisateur);
        if (!empty($result) && isset($result[0])) {
            /** @var Media $media */
            $media = $result[0];
            $media->setContext('image');
            $format = $this->providerImage->getFormatName($media, 'big');
            return str_replace('.jpg', '.jpeg', $this->providerImage->generatePublicUrl($media, $format));
        }
        return null;
    }
}
