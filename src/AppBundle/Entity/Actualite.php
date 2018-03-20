<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Actualite
 *
 * @ORM\Table(name="actualite", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="slug", columns={"slug"}),
 *     @ORM\Index(name="affiche", columns={"affiche"}),
 *     @ORM\Index(name="annule", columns={"annule"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActualiteRepository")
 */
class Actualite
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
     * @var  string
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
     * @ORM\Column(name="date_debut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime", nullable=true)
     */
    private $datePublication;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove", "refresh"}, fetch="LAZY")
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $image;

    /**
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="actualiteSupervise")
     * @ORM\JoinTable(name="actualitess_surpervisions",
     *     joinColumns={@ORM\JoinColumn(name="actualite_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $superviseurs;


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
     * @return Actualite
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
     * Set affiche
     *
     * @param boolean $affiche
     *
     * @return Actualite
     */
    public function setAffiche($affiche): Actualite
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
     * @return Actualite
     */
    public function setAnnule($annule): Actualite
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
        $this->annule       = false;
        $this->affiche      = true;
        $this->superviseurs = new ArrayCollection();
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Actualite
     */
    public function setDateDebut($dateDebut): Actualite
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut():? \DateTime
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Actualite
     */
    public function setDateFin($dateFin): Actualite
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin():? \DateTime
    {
        return $this->dateFin;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Actualite
     */
    public function setSlug($slug): Actualite
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
     * @return int
     */
    public function getVersion():? int
    {
        return $this->version;
    }

    /**
     * @param int $version
     *
     * @return Actualite
     */
    public function setVersion($version): Actualite
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set image
     *
     * @param MediaInterface $image
     *
     * @return Actualite
     */
    public function setImage(MediaInterface $image = null): Actualite
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
     * @return Actualite
     */
    public function setContenu($contenu): Actualite
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
     * @return Actualite
     */
    public function addSuperviseur(Utilisateur $superviseur): Actualite
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
     * @return Actualite
     */
    public function setTimestampCreation($timestampCreation): Actualite
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
     * @return Actualite
     */
    public function setTimestampModification($timestampModification): Actualite
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
}
