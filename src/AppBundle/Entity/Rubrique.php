<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Rubrique
 *
 * @ORM\Table(name="rubrique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RubriqueRepository")
 */
class Rubrique
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;
	
	/**
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    private $route;
    
    /**
    * @Gedmo\Slug(fields={"nom"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="integer", length=11)
     */
    private $ordre;
   
    /**
     * @ORM\ManyToMany(targetEntity="Rubrique",  inversedBy="parents")
     * @ORM\JoinTable(name="Rubrique_relations",
     *     joinColumns={@ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="enfant_rubrique_id", referencedColumnName="id")}
     * )
     */
    private $enfants;
 
 
 
    /**
     * @ORM\ManyToMany(targetEntity="Rubrique",  mappedBy="enfants")
     */
    private $parents;
	
    /**
     *
     * @ORM\ManyToOne(targetEntity="TypeRubrique", inversedBy="rubriques")
     * @ORM\JoinColumn(nullable=false, name="fk_type", referencedColumnName="id")
     */
    private $type;
    
    /**
     * @ORM\OneToMany(targetEntity="Contenu", mappedBy="rubrique")
     */
    private $contenu;
    
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
     * Rubrique constructor.
     */
    public function __construct()
    {
        $this->enfants = new ArrayCollection();
        $this->parents = new ArrayCollection();
    }

    /**
     * Rubrique affichage
     * @return string
     */
    public function __toString() {
        return $this->getNom();
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
     * @return Rubrique
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
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
	
	/**
     * Set slug
     *
     * @param string $slug
     *
     * @return Rubrique
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }


    /**
     * Add enfant
     *
     * @param \AppBundle\Entity\Rubrique $enfant
     *
     * @return Rubrique
     */
    public function addEnfant(Rubrique $enfant)
    {
        $this->enfants[] = $enfant;

        return $this;
    }

    /**
     * Remove enfant
     *
     * @param \AppBundle\Entity\Rubrique $enfant
     */
    public function removeEnfant(Rubrique $enfant)
    {
        $this->enfants->removeElement($enfant);
    }

    /**
     * Get enfants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfants()
    {
        return $this->enfants;
    }

    /**
     * Add parent
     *
     * @param \AppBundle\Entity\Rubrique $parent
     *
     * @return Rubrique
     */
    public function addParent(Rubrique $parent)
    {
        $this->parents[] = $parent;

        return $this;
    }

    /**
     * Remove parent
     *
     * @param \AppBundle\Entity\Rubrique $parent
     */
    public function removeParent(Rubrique $parent)
    {
        $this->parents->removeElement($parent);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Rubrique
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\TypeRubrique $type
     *
     * @return Rubrique
     */
    public function setType(TypeRubrique $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\TypeRubrique
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Rubrique
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Add contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return Rubrique
     */
    public function addContenu(Contenu $contenu)
    {
        $this->contenu[] = $contenu;

        return $this;
    }

    /**
     * Remove contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     */
    public function removeContenu(Contenu $contenu)
    {
        $this->contenu->removeElement($contenu);
    }

    /**
     * Get contenu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContenu()
    {
        return $this->contenu;
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
     * @return Rubrique
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
     * @return Rubrique
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
}
