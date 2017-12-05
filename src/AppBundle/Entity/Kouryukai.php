<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;

/**
 * Kouryukai
 *
 * @ORM\Table(name="kouryukai", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="slug", columns={"slug"}),
 *     @ORM\Index(name="affiche", columns={"affiche"}),
 *     @ORM\Index(name="annule", columns={"annule"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KouryukaiRepository")
 */
class Kouryukai
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
	
   /**
    * @var string
    *
    * @Gedmo\Slug(fields={"nom"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="affiche", type="boolean")
     */
    private $affiche;

    /**
     * @var boolean
     *
     * @ORM\Column(name="annule", type="boolean")
     */
    private $annule;
	
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    
   /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_limite", type="datetime", nullable=true)
     */
    private $dateLimite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime", nullable=true)
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="url_inscription", type="string", length=255, nullable=true)
     */
    private $urlInscription;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=true)
     */
    private $nbPlace;
    
    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove", "refresh"}, fetch="LAZY")
     */
    private $image;
   
   /**
    * @var string
    *
    * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
    */
    private $contenu;

    
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="kouryukaiSupervise")
     * @ORM\JoinTable(name="kouryukais_surpervisions",
     *     joinColumns={@ORM\JoinColumn(name="kouryukai_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $superviseurs;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="reserve_membre", type="boolean")
     */
    private $reserveMembre;
    
    
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="kouryukais")
     * @ORM\JoinTable(name="kouryukais_inscriptions",
     *     joinColumns={@ORM\JoinColumn(name="kouryukai_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $inscrits;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=6, nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=60, nullable=true)
     */
    private $ville;

    /**
     * @var float
     *
     * @ORM\Column(name="coord_geo_latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $coordGeoLatitude;

    /**
     * @var float
     *
     * @ORM\Column(name="coord_geo_longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $coordGeoLongitude;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_creation", type="datetime", nullable=true)
     */
    private $timestampCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_modification", type="datetime", nullable=true)
     */
    private $timestampModification;
    
    /**
     * @var string
     *
     * @ORM\Column(name="utilisateur_creation", type="string", length=255, nullable=true)
     */
    private $utilisateurCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="utilisateur_modification", type="string", length=255, nullable=true)
     */
    private $utilisateurModification;
    
    /**
     * For Sonata Admin Doctrine lock
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Version
     */
    protected $version;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->superviseurs     = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Kouryukai
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Kouryukai
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set affiche
     *
     * @param boolean $affiche
     *
     * @return Kouryukai
     */
    public function setAffiche($affiche)
    {
        $this->affiche = $affiche;

        return $this;
    }

    /**
     * Get affiche
     *
     * @return boolean
     */
    public function getAffiche()
    {
        return $this->affiche;
    }

    /**
     * Set annule
     *
     * @param boolean $annule
     *
     * @return Kouryukai
     */
    public function setAnnule($annule)
    {
        $this->annule = $annule;

        return $this;
    }

    /**
     * Get annule
     *
     * @return boolean
     */
    public function getAnnule()
    {
        return $this->annule;
    }

    /**
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Kouryukai
     */
    public function setNbPlace($nbPlace)
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get nbPlace
     *
     * @return integer
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
    }



    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Kouryukai
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dateLimite
     *
     * @param \DateTime $dateLimite
     *
     * @return Kouryukai
     */
    public function setDateLimite($dateLimite)
    {
        $this->dateLimite = $dateLimite;

        return $this;
    }

    /**
     * Get dateLimite
     *
     * @return \DateTime
     */
    public function getDateLimite()
    {
        return $this->dateLimite;
    }

    /**
     * Set image
     *
     * @param MediaInterface $image
     *
     * @return Kouryukai
     */
    public function setImage(MediaInterface $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return MediaInterface
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Kouryukai
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }
    
    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * @param int $version
     * 
     * @return Kouryukai
     */
    public function setVersion($version)
    {
        $this->version = $version;
        
        return $this;
    }

    /**
     * Add superviseur
     *
     * @param Utilisateur $superviseur
     *
     * @return Kouryukai
     */
    public function addSuperviseur(Utilisateur $superviseur)
    {
        $this->superviseurs[] = $superviseur;

        return $this;
    }

    /**
     * Remove superviseur
     *
     * @param Utilisateur $superviseur
     */
    public function removeSuperviseur(Utilisateur $superviseur)
    {
        $this->superviseurs->removeElement($superviseur);
    }

    /**
     * Get superviseurs
     *
     * @return ArrayCollection
     */
    public function getSuperviseurs()
    {
        return $this->superviseurs;
    }

    /**
     * Set reserveMembre
     *
     * @param boolean $reserveMembre
     *
     * @return Kouryukai
     */
    public function setReserveMembre($reserveMembre)
    {
        $this->reserveMembre = $reserveMembre;

        return $this;
    }

    /**
     * Get reserveMembre
     *
     * @return boolean
     */
    public function getReserveMembre()
    {
        return $this->reserveMembre;
    }

    
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setTimestampCreation(new \DateTime('now'));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setTimestampModification(new \DateTime('now'));
    }
    
    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     *
     * @return Kouryukai
     */
    public function setTimestampCreation($timestampCreation)
    {
        $this->timestampCreation = $timestampCreation;

        return $this;
    }

    /**
     * Get timestampCreation
     *
     * @return \DateTime
     */
    public function getTimestampCreation()
    {
        return $this->timestampCreation;
    }
    
    /**
     * Set timestampModification
     *
     * @param \DateTime $timestampModification
     *
     * @return Kouryukai
     */
    public function setTimestampModification($timestampModification)
    {
        $this->timestampModification = $timestampModification;

        return $this;
    }

    /**
     * Get timestampModification
     *
     * @return \DateTime
     */
    public function getTimestampModification()
    {
        return $this->timestampModification;
    }
    
    /**
     * @return string
     */
    public function getUtilisateurCreation()
    {
        return $this->utilisateurCreation;
    }

    /**
     * @param string $utilisateurCreation
     */
    public function setUtilisateurCreation($utilisateurCreation)
    {
        $this->utilisateurCreation = $utilisateurCreation;
    }

    /**
     * @return string
     */
    public function getUtilisateurModification()
    {
        return $this->utilisateurModification;
    }

    /**
     * @param string $utilisateurModification
     */
    public function setUtilisateurModification($utilisateurModification)
    {
        $this->utilisateurModification = $utilisateurModification;
    }
    
    /**
     * Add inscrit
     *
     * @param Utilisateur $inscrits
     *
     * @return Kouryukai
     */
    public function addInscrit(Utilisateur $inscrits)
    {
        $this->inscrits[] = $inscrits;

        return $this;
    }

    /**
     * Remove inscrit
     *
     * @param Utilisateur $inscrits
     */
    public function removeInscrit(Utilisateur $inscrits)
    {
        $this->inscrits->removeElement($inscrits);
    }

    /**
     * Get inscrits
     *
     * @return ArrayCollection
     */
    public function getInscrits()
    {
        return $this->inscrits;
    }

    /**
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * @param \DateTime $datePublication
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    }

    /**
     * @return string
     */
    public function getUrlInscription()
    {
        return $this->urlInscription;
    }

    /**
     * @param string $urlInscription
     */
    public function setUrlInscription($urlInscription)
    {
        $this->urlInscription = $urlInscription;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Kouryukai
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Kouryukai
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Kouryukai
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set coordGeoLatitude
     *
     * @param float $coordGeoLatitude
     *
     * @return Kouryukai
     */
    public function setCoordGeoLatitude($coordGeoLatitude)
    {
        $this->coordGeoLatitude = $coordGeoLatitude;

        return $this;
    }

    /**
     * Get coordGeoLatitude
     *
     * @return float
     */
    public function getCoordGeoLatitude()
    {
        return $this->coordGeoLatitude;
    }

    /**
     * Set coordGeoLongitude
     *
     * @param float $coordGeoLongitude
     *
     * @return Kouryukai
     */
    public function setCoordGeoLongitude($coordGeoLongitude)
    {
        $this->coordGeoLongitude = $coordGeoLongitude;

        return $this;
    }

    /**
     * Get coordGeoLongitude
     *
     * @return float
     */
    public function getCoordGeoLongitude()
    {
        return $this->coordGeoLongitude;
    }

    /**
     * @param $latlng
     * @return $this
     */
    public function setLatLng($latlng)
    {
        $this->setCoordGeoLatitude($latlng['lat']);
        $this->setCoordGeoLongitude($latlng['lng']);
        return $this;
    }

    /**
     * @Assert\NotBlank()
     * @OhAssert\LatLng()
     */
    public function getLatLng()
    {
        return array('lat' => $this->getCoordGeoLatitude(),'lng' => $this->getCoordGeoLongitude());
    }
}
