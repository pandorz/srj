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
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;
    
    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove", "refresh"}, fetch="LAZY")
     */
    private $image;
   
   /**
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="actualiteSupervise")
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
    public function getId()
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
    public function getNom()
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
     * @return Actualite
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
     * @return ObjetMuseeMouvement
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return ObjetMuseeMouvement
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
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
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * @param int $version
     * 
     * @return Actualite
     */
    public function setVersion($version)
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
    public function setImage(MediaInterface $image)
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
     * @return Musee
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
     * Add superviseur
     *
     * @param Utilisateur $superviseur
     *
     * @return Actualite
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
     * @return Musee
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
     * @return Musee
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
    public function setUtilisateurCreation(string $utilisateurCreation)
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
    public function setUtilisateurModification(string $utilisateurModification)
    {
        $this->utilisateurModification = $utilisateurModification;
    }
    
    /**
     * Add inscrit
     *
     * @param Utilisateur $inscrits
     *
     * @return Cour
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
}
