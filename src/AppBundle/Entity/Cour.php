<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cour
 *
 * @ORM\Table(name="cour", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="affiche", columns={"affiche"}),
 *     @ORM\Index(name="annule", columns={"annule"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourRepository")
 */
class Cour
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
     * @ORM\Column(name="annule", type="boolean")
     */
    private $annule;

    /**
     * @var boolean
     *
     * @ORM\Column(name="affiche", type="boolean")
     */
    private $affiche;
	
    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="cours")
     */
    private $users;
	
    /**
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;
	
    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="professeurDe")
     * @ORM\JoinColumn(nullable=false, name="fk_professeur", referencedColumnName="id")
     */
    private $professeur;
    
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
     * @return Cour
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
     * Set annule
     *
     * @param boolean $annule
     *
     * @return Cour
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
     * @param int $version
     * 
     * @return Cour
     */
    public function setVersion($version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set affiche
     *
     * @param boolean $affiche
     *
     * @return Cour
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
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->dates = new ArrayCollection();
    }

    /**
     * Add user
     *
     * @param Utilisateur $user
     *
     * @return Cour
     */
    public function addUser(Utilisateur $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param Utilisateur $user
     */
    public function removeUser(Utilisateur $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Cour
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
     * Set professeur
     *
     * @param Utilisateur $professeur
     *
     * @return Cour
     */
    public function setProfesseur(Utilisateur $professeur)
    {
        $this->professeur = $professeur;

        return $this;
    }

    /**
     * Get professeur
     *
     * @return Utilisateur
     */
    public function getProfesseur()
    {
        return $this->professeur;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Cour
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
}
