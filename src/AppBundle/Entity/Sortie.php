<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Sortie
 *
 * @ORM\Table(name="sortie", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="slug", columns={"slug"}),
 *     @ORM\Index(name="affiche", columns={"affiche"}),
 *     @ORM\Index(name="annule", columns={"annule"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SortieRepository")
 */
class Sortie
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
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="sortieSupervise")
     * @ORM\JoinTable(name="sorties_surpervisions",
     *     joinColumns={@ORM\JoinColumn(name="sortie_id", referencedColumnName="id")},
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
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="sorties")
     * @ORM\JoinTable(name="sorties_inscriptions",
     *     joinColumns={@ORM\JoinColumn(name="sortie_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $inscrits;
    
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
        $this->prix             = 0;
        $this->prixMembre       = 0;
    }


    /**
     * Get id
     *
     * @return integer
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
     * @return Sortie
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
    public function getNom():? string
    {
        return $this->nom;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Sortie
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
    public function getSlug():? string
    {
        return $this->slug;
    }

    /**
     * Set affiche
     *
     * @param boolean $affiche
     *
     * @return Sortie
     */
    public function setAffiche($affiche): Sortie
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
     * @return Sortie
     */
    public function setAnnule($annule): Sortie
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
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Sortie
     */
    public function setNbPlace($nbPlace): Sortie
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Sortie
     */
    public function setDate($date): Sortie
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
     * Set dateLimite
     *
     * @param \DateTime $dateLimite
     *
     * @return Sortie
     */
    public function setDateLimite($dateLimite): Sortie
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
     *
     * @return Sortie
     */
    public function setImage(MediaInterface $image = null): Sortie
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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Sortie
     */
    public function setContenu($contenu): Sortie
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
     * @return int
     */
    public function getVersion():? int
    {
        return $this->version;
    }
    
    /**
     * @param int $version
     *
     * @return Sortie
     */
    public function setVersion($version): Sortie
    {
        $this->version = $version;
        
        return $this;
    }

    /**
     * Add superviseur
     *
     * @param Utilisateur $superviseur
     *
     * @return Sortie
     */
    public function addSuperviseur(Utilisateur $superviseur): Sortie
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
     * @return Sortie
     */
    public function setReserveMembre($reserveMembre): Sortie
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
     * @return Sortie
     */
    public function setPrix($prix): Sortie
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
     * @return Sortie
     */
    public function setPrixMembre($prixMembre): Sortie
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
     * @return Sortie
     */
    public function setTimestampCreation($timestampCreation): Sortie
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
     * @return Sortie
     */
    public function setTimestampModification($timestampModification): Sortie
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
     * @return Sortie
     */
    public function addInscrit(Utilisateur $inscrits): Sortie
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
}
