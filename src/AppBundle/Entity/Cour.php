<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cour
 *
 * @ORM\Table(name="cour")
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
     * @var int
     *
     * @ORM\Column(name="annule", type="integer")
     */
    private $annule;

    /**
     * @var int
     *
     * @ORM\Column(name="affiche", type="integer")
     */
    private $affiche;
	
    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="cours")
     */
    private $users;
	
    /**
     *
     * @ORM\ManyToMany(targetEntity="DateCalendrier", inversedBy="cours")
     * @ORM\JoinColumn(nullable=false, name="fk_date", referencedColumnName="id")
     */
    private $dates;
	
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
     * @param integer $annule
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
     * @return int
     */
    public function getAnnule()
    {
        return $this->annule;
    }

    /**
     * Set affiche
     *
     * @param integer $affiche
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
     * @return int
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
		$this->setAnnule(0);
		$this->setAffiche(1);
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\Utilisateur $user
     *
     * @return Cour
     */
    public function addUtilisateur(Utilisateur $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\Utilisateur $user
     */
    public function removeUtilisateur(Utilisateur $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateurs()
    {
        return $this->users;
    }

    /**
     * Add date
     *
     * @param \AppBundle\Entity\DateCalendrier $date
     *
     * @return Cour
     */
    public function addDate(DateCalendrier $date)
    {
        $this->dates[] = $date;

        return $this;
    }

    /**
     * Remove date
     *
     * @param \AppBundle\Entity\DateCalendrier $date
     */
    public function removeDate(DateCalendrier $date)
    {
        $this->dates->removeElement($date);
    }

    /**
     * Get dates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Set professeur
     *
     * @param \AppBundle\Entity\Utilisateur $professeur
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
     * @return \AppBundle\Entity\Utilisateur
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
