<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Atelier
 *
 * @ORM\Table(name="atelier", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="slug", columns={"slug"}),
 *     @ORM\Index(name="affiche", columns={"affiche"}),
 *     @ORM\Index(name="annule", columns={"annule"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AtelierRepository")
 */
class Atelier
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
     * @ORM\joinColumn(onDelete="SET NULL")
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
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="atelierSupervise")
     * @ORM\JoinTable(name="ateliers_surpervisions",
     *     joinColumns={@ORM\JoinColumn(name="atelier_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $superviseurs;

    /**
     * @var boolean
     *
     * @ORM\Column(name="reserveMembre", type="boolean")
     */
    private $reserveMembre;

    /**
     * @var double
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var double
     *
     * @ORM\Column(name="prix_membre", type="float")
     */
    private $prixMembre;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="ateliers")
     * @ORM\JoinTable(name="ateliers_inscriptions",
     *     joinColumns={@ORM\JoinColumn(name="atelier_id", referencedColumnName="id")},
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
     * Get id
     *
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Atelier
     */
    public function setNom($nom): Atelier
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom():? string
    {
        return $this->nom;
    }

    /**
     * Set affiche
     *
     * @param boolean $affiche
     *
     * @return Atelier
     */
    public function setAffiche($affiche): Atelier
    {
        $this->affiche = $affiche;

        return $this;
    }

    /**
     * Get affiche
     *
     * @return boolean
     */
    public function getAffiche():? bool
    {
        return $this->affiche;
    }

    /**
     * Set annule
     *
     * @param boolean $annule
     *
     * @return Atelier
     */
    public function setAnnule($annule): Atelier
    {
        $this->annule = $annule;

        return $this;
    }

    /**
     * Get annule
     *
     * @return boolean
     */
    public function getAnnule():? bool
    {
        return $this->annule;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->superviseurs = new ArrayCollection();
        $this->prix         = 0;
        $this->prixMembre   = 0;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Atelier
     */
    public function setDate($date): Atelier
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate():? \DateTime
    {
        return $this->date;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Atelier
     */
    public function setSlug($slug): Atelier
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug():? string
    {
        return $this->slug;
    }

    /**
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Atelier
     */
    public function setNbPlace($nbPlace): Atelier
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get nbPlace
     *
     * @return integer
     */
    public function getNbPlace():? int
    {
        return $this->nbPlace;
    }

    /**
     * Set dateLimite
     *
     * @param \DateTime $dateLimite
     *
     * @return Atelier
     */
    public function setDateLimite($dateLimite): Atelier
    {
        $this->dateLimite = $dateLimite;

        return $this;
    }

    /**
     * Get dateLimite
     *
     * @return \DateTime
     */
    public function getDateLimite():? \DateTime
    {
        return $this->dateLimite;
    }

    /**
     * Set image
     *
     * @param MediaInterface $image
     * @return Atelier
     */
    public function setImage(MediaInterface $image = null): Atelier
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return MediaInterface
     */
    public function getImage():? MediaInterface
    {
        return $this->image;
    }

    /**
     * @return int
     */
    public function getVersion():? int
    {
        return $this->version;
    }

    /**
     * @param int $version
     *
     * @return Atelier
     */
    public function setVersion($version): Atelier
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Atelier
     */
    public function setContenu($contenu): Atelier
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu():? string
    {
        return $this->contenu;
    }

    /**
     * Add superviseur
     *
     * @param Utilisateur $superviseur
     *
     * @return Atelier
     */
    public function addSuperviseur(Utilisateur $superviseur): Atelier
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
    public function getSuperviseurs():? ArrayCollection
    {
        return $this->superviseurs;
    }

    /**
     * Set reserveMembre
     *
     * @param boolean $reserveMembre
     *
     * @return Atelier
     */
    public function setReserveMembre($reserveMembre): Atelier
    {
        $this->reserveMembre = $reserveMembre;

        return $this;
    }

    /**
     * Get reserveMembre
     *
     * @return boolean
     */
    public function getReserveMembre():? bool
    {
        return $this->reserveMembre;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Atelier
     */
    public function setPrix($prix): Atelier
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix():? int
    {
        return $this->prix;
    }

    /**
     * Set prixMembre
     *
     * @param integer $prixMembre
     *
     * @return Atelier
     */
    public function setPrixMembre($prixMembre): Atelier
    {
        $this->prixMembre = $prixMembre;

        return $this;
    }

    /**
     * Get prixMembre
     *
     * @return integer
     */
    public function getPrixMembre():? int
    {
        return $this->prixMembre;
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
     * @return Atelier
     */
    public function setTimestampCreation($timestampCreation): Atelier
    {
        $this->timestampCreation = $timestampCreation;

        return $this;
    }

    /**
     * Get timestampCreation
     *
     * @return \DateTime
     */
    public function getTimestampCreation():? \DateTime
    {
        return $this->timestampCreation;
    }

    /**
     * Set timestampModification
     *
     * @param \DateTime $timestampModification
     *
     * @return Atelier
     */
    public function setTimestampModification($timestampModification): Atelier
    {
        $this->timestampModification = $timestampModification;

        return $this;
    }

    /**
     * Get timestampModification
     *
     * @return \DateTime
     */
    public function getTimestampModification():? \DateTime
    {
        return $this->timestampModification;
    }

    /**
     * @return string
     */
    public function getUtilisateurCreation():? string
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
    public function getUtilisateurModification():? string
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
     * @return Atelier
     */
    public function addInscrit(Utilisateur $inscrits): Atelier
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
    public function getInscrits():? ArrayCollection
    {
        return $this->inscrits;
    }

    /**
     * @return \DateTime
     */
    public function getDatePublication():? \DateTime
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
    public function getUrlInscription():? string
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
     * @return Atelier
     */
    public function setAdresse($adresse): Atelier
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse():? string
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Atelier
     */
    public function setCodePostal($codePostal): Atelier
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal():? string
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Atelier
     */
    public function setVille($ville): Atelier
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille():? string
    {
        return $this->ville;
    }

    /**
     * Set coordGeoLatitude
     *
     * @param float $coordGeoLatitude
     *
     * @return Atelier
     */
    public function setCoordGeoLatitude($coordGeoLatitude): Atelier
    {
        $this->coordGeoLatitude = $coordGeoLatitude;

        return $this;
    }

    /**
     * Get coordGeoLatitude
     *
     * @return float
     */
    public function getCoordGeoLatitude():? float
    {
        return $this->coordGeoLatitude;
    }

    /**
     * Set coordGeoLongitude
     *
     * @param float $coordGeoLongitude
     *
     * @return Atelier
     */
    public function setCoordGeoLongitude($coordGeoLongitude): Atelier
    {
        $this->coordGeoLongitude = $coordGeoLongitude;

        return $this;
    }

    /**
     * Get coordGeoLongitude
     *
     * @return float
     */
    public function getCoordGeoLongitude():? float
    {
        return $this->coordGeoLongitude;
    }

    /**
     * @param $latlng
     * @return $this
     */
    public function setLatLng($latlng): Atelier
    {
        $this->setCoordGeoLatitude($latlng['lat']);
        $this->setCoordGeoLongitude($latlng['lng']);

        return $this;
    }

    /**
     * @Assert\NotBlank()
     * @OhAssert\LatLng()
     * @return array
     */
    public function getLatLng(): array
    {
        return array('lat' => $this->getCoordGeoLatitude(), 'lng' => $this->getCoordGeoLongitude());
    }
}
