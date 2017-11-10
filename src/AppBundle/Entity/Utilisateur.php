<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Model\MediaInterface;


/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={
 *     @ORM\Index(name="email", columns={"email"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Utilisateur extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;    
    
   /**
    * @var string
    *
    * @Gedmo\Slug(fields={"lastname","firstname"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;
    
    /**
    * @var boolean
    *
    * @ORM\Column(name="acces_site", type="boolean")
    */
    private $acces_site;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="integer")
     */
    private $locked;
	
    /**
    * @var boolean
    *
    * @ORM\Column(name="estProfesseur", type="boolean")
    */
    private $estProfesseur;    
    
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Cour", mappedBy="inscrits")
     */
    private $cours;
    
    /** @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Sortie", mappedBy="inscrits")
     */
    private $sorties;
    
    /** @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Atelier", mappedBy="inscrits")
     */
    private $ateliers;
    
    /** @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Atelier", mappedBy="superviseurs")
     */
    private $atelierSupervise;

    /** @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Actualite", mappedBy="superviseurs")
     */
    private $actualiteSupervise;
    
    /** @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Evenement", mappedBy="superviseurs")
     */
    private $evenementSupervise;
    
    /** @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Sortie", mappedBy="superviseurs")
     */
    private $sortieSupervise;
	
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Cour", mappedBy="professeur")
     */
    private $professeurDe;
        
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur",  inversedBy="parent")
     * @ORM\JoinTable(name="Utilisateur_relations",
     *     joinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="enfant_utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $sousUtilisateurs;
    
    /**
     * @var Utilisateur
     *
     * @ORM\OneToMany(targetEntity="Utilisateur", mappedBy="sousUtilisateurs")
     */
    private $parent;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove", "refresh"}, fetch="LAZY")
     */
    private $image;

    /**
    * Constructor
    */
    public function __construct() 
    {
        parent::__construct();
        $this->setEstProfesseur(false);
        $this->setAccesSite(true);
        $this->setLocked(false);
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
     * Set email
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    

    /**
     * Set accesSite
     *
     * @param boolean $accesSite
     *
     * @return Utilisateur
     */
    public function setAccesSite($accesSite)
    {
        $this->acces_site = $accesSite;

        return $this;
    }

    /**
     * Get accesSite
     *
     * @return boolean
     */
    public function getAccesSite()
    {
        return $this->acces_site;
    }

    /**
     * Add cour
     *
     * @param Cour $cour
     *
     * @return Utilisateur
     */
    public function addCour(Cour $cour)
    {
        $this->cours[] = $cour;

        return $this;
    }

    /**
     * Remove cour
     *
     * @param Cour $cour
     */
    public function removeCour(Cour $cour)
    {
        $this->cours->removeElement($cour);
    }

    /**
     * Get cours
     *
     * @return ArrayCollection
     */
    public function getCours()
    {
        return $this->cours;
    }    

    /**
     * Add atelier
     *
     * @param Atelier $atelier
     *
     * @return Utilisateur
     */
    public function addAtelier(Atelier $atelier)
    {
        $this->ateliers[] = $atelier;

        return $this;
    }

    /**
     * Remove atelier
     *
     * @param Atelier $atelier
     */
    public function removeAtelier(Atelier $atelier)
    {
        $this->ateliers->removeElement($atelier);
    }

    /**
     * Get atelier
     *
     * @return ArrayCollection
     */
    public function getAteliers()
    {
        return $this->ateliers;
    }
    
    /**
     * Add sortie
     *
     * @param Sortie $sortie
     *
     * @return Utilisateur
     */
    public function addSortie(Sortie $sortie)
    {
        $this->sorties[] = $sortie;

        return $this;
    }

    /**
     * Remove atelier
     *
     * @param Sortie $sortie
     */
    public function removeSortie(Sortie $sortie)
    {
        $this->sorties->removeElement($sortie);
    }

    /**
     * Get atelier
     *
     * @return ArrayCollection
     */
    public function getSorties()
    {
        return $this->sorties;
    }

    /**
     * Add professeurDe
     *
     * @param Cour $professeurDe
     *
     * @return Utilisateur
     */
    public function addProfesseurDe(Cour $professeurDe)
    {
        $this->professeurDe[] = $professeurDe;

        return $this;
    }

    /**
     * Remove professeurDe
     *
     * @param Cour $professeurDe
     */
    public function removeProfesseurDe(Cour $professeurDe)
    {
        $this->professeurDe->removeElement($professeurDe);
    }

    /**
     * Get professeurDe
     *
     * @return ArrayCollection
     */
    public function getProfesseurDe()
    {
        return $this->professeurDe;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Utilisateur
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
     * Set estProfesseur
     *
     * @param boolean $estProfesseur
     *
     * @return Utilisateur
     */
    public function setEstProfesseur($estProfesseur)
    {
        //si pas sous utilisateur
        if(is_null($this->getParent()))
            $this->estProfesseur = $estProfesseur;

        return $this;
    }

    /**
     * Get estProfesseur
     *
     * @return boolean
     */
    public function getEstProfesseur()
    {
        return $this->estProfesseur;
    }

    /**
     * Add sousUtilisateur
     *
     * @param Utilisateur $sousUtilisateur
     *
     * @return Utilisateur
     */
    public function addSousUtilisateur(Utilisateur $sousUtilisateur)
    {
        $this->sousUtilisateurs[] = $sousUtilisateur;

        return $this;
    }

    /**
     * Remove sousUtilisateur
     *
     * @param Utilisateur $sousUtilisateur
     */
    public function removeSousUtilisateur(Utilisateur $sousUtilisateur)
    {
        $this->sousUtilisateurs->removeElement($sousUtilisateur);
    }

    /**
     * Get sousUtilisateurs
     *
     * @return ArrayCollection
     */
    public function getSousUtilisateurs()
    {
        return $this->sousUtilisateurs;
    }

    /**
     * Set parent
     * @param Utilisateur $parent
     * @return Utilisateur
     */
    public function setParent(Utilisateur $parent)
    {
        $this->parent = $parent;
        
        return $this;
    }

    /**
     * Get parents
     *
     * @return Utilisateur
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add atelierSupervise
     *
     * @param Atelier $atelierSupervise
     *
     * @return Utilisateur
     */
    public function addAtelierSupervise(Atelier $atelierSupervise)
    {
        $this->atelierSupervise[] = $atelierSupervise;

        return $this;
    }

    /**
     * Remove atelierSupervise
     *
     * @param Atelier $atelierSupervise
     */
    public function removeAtelierSupervise(Atelier $atelierSupervise)
    {
        $this->atelierSupervise->removeElement($atelierSupervise);
    }

    /**
     * Get atelierSupervise
     *
     * @return ArrayCollection
     */
    public function getAtelierSupervise()
    {
        return $this->atelierSupervise;
    }

    /**
     * Add evenementSupervise
     *
     * @param Evenement $evenementSupervise
     *
     * @return Utilisateur
     */
    public function addEvenementSupervise(Evenement $evenementSupervise)
    {
        $this->evenementSupervise[] = $evenementSupervise;

        return $this;
    }

    /**
     * Remove evenementSupervise
     *
     * @param Evenement $evenementSupervise
     */
    public function removeEvenementSupervise(Evenement $evenementSupervise)
    {
        $this->evenementSupervise->removeElement($evenementSupervise);
    }

    /**
     * Get evenementSupervise
     *
     * @return ArrayCollection
     */
    public function getActualiteSupervise()
    {
        return $this->actualiteSupervise;
    }

    /**
     * Add evenementSupervise
     *
     * @param Actualite $actualiteSupervise
     *
     * @return Utilisateur
     */
    public function addActualiteSupervise(Actualite $actualiteSupervise)
    {
        $this->actualiteSupervise[] = $actualiteSupervise;

        return $this;
    }

    /**
     * Remove evenementSupervise
     *
     * @param Actualite $actualiteSupervise
     */
    public function removeActualiteSupervise(Actualite $actualiteSupervise)
    {
        $this->actualiteSupervise->removeElement($actualiteSupervise);
    }

    /**
     * Get evenementSupervise
     *
     * @return ArrayCollection
     */
    public function getEvenementSupervise()
    {
        return $this->evenementSupervise;
    }

    /**
     * Add sortieSupervise
     *
     * @param Sortie $sortieSupervise
     *
     * @return Utilisateur
     */
    public function addSortieSupervise(Sortie $sortieSupervise)
    {
        $this->sortieSupervise[] = $sortieSupervise;

        return $this;
    }

    /**
     * Remove sortieSupervise
     *
     * @param Sortie $sortieSupervise
     */
    public function removeSortieSupervise(Sortie $sortieSupervise)
    {
        $this->sortieSupervise->removeElement($sortieSupervise);
    }

    /**
     * Get sortieSupervise
     *
     * @return ArrayCollection
     */
    public function getSortieSupervise()
    {
        return $this->sortieSupervise;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return Utilisateur
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }
    
    public function __toString() {
        if (!empty($this->getFirstname()) && !empty($this->getLastname())) {
            return $this->getFullname();
        }
        return parent::__toString();
    }

    /**
     * Set image
     *
     * @param MediaInterface $image
     *
     * @return Utilisateur
     */
    public function setImage(MediaInterface $image  = null)
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
}
