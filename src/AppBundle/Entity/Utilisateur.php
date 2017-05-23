<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(name="nom", type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100, nullable=true)
     */
    private $prenom;
    
    /**
    * @Gedmo\Slug(fields={"nom","prenom"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;
    
    /**
    * @var int
    *
    * @ORM\Column(name="acces_site", type="integer")
    */
    private $acces_site;

    /**
     * @var int
     *
     * @ORM\Column(name="locked", type="integer")
     */
    private $locked;
	
    /**
    * @var int
    *
    * @ORM\Column(name="est_professeur", type="integer")
    */
    private $est_professeur;
    
    /**
    * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist"})
    */
    private $image;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Cour", inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=true, name="fk_cours", referencedColumnName="id")
     */
    private $cours;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Atelier", inversedBy="superviseurs")
     * @ORM\JoinColumn(nullable=true, name="fk_atelier_supervise", referencedColumnName="id")
     */
    private $atelierSupervise;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Evenement", inversedBy="superviseurs")
     * @ORM\JoinColumn(nullable=true, name="fk_evenement_supervise", referencedColumnName="id")
     */
    private $evenementSupervise;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Sortie", inversedBy="superviseurs")
     * @ORM\JoinColumn(nullable=true, name="fk_sortie_supervise", referencedColumnName="id")
     */
    private $sortieSupervise;

	
    /**
     * @ORM\OneToMany(targetEntity="Cour", mappedBy="professeur")
     */
    private $professeurDe;
    
    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="utilisateur")
     */
    private $inscriptions;
    
    /**
     * @ORM\OneToMany(targetEntity="Contenu", mappedBy="auteur")
     */
    private $auteurDe;
    
    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur",  inversedBy="parents")
     * @ORM\JoinTable(name="Utilisateur_relations",
     *     joinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="enfant_utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $sousUtilisateurs;
    
    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur",  mappedBy="sousUtilisateurs")
     */
    private $parents;


    /**
    * Constructor
    */
    public function __construct() 
    {
        parent::__construct();
	$this->cours                = new ArrayCollection();
        $this->inscriptions         = new ArrayCollection();
        $this->sortieSupervise      = new ArrayCollection();
        $this->evenementSupervise   = new ArrayCollection();
        $this->atelierSupervise     = new ArrayCollection();
        $this->professeurDe         = new ArrayCollection();
        $this->sousUtilisateurs     = new ArrayCollection();
        $this->parents              = new ArrayCollection();
        $this->setEstProfesseur(0);
        $this->setAccesSite(1);
        $this->setLocked(0);
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
     * @return Utilisateur
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
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
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Utilisateur
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set accesSite
     *
     * @param integer $accesSite
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
     * @return integer
     */
    public function getAccesSite()
    {
        return $this->acces_site;
    }

    /**
     * Add cour
     *
     * @param \AppBundle\Entity\Cour $cour
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
     * @param \AppBundle\Entity\Cour $cour
     */
    public function removeCour(Cour $cour)
    {
        $this->cours->removeElement($cour);
    }

    /**
     * Get cours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCours()
    {
        return $this->cours;
    }


    /**
     * Add professeurDe
     *
     * @param \AppBundle\Entity\Cour $professeurDe
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
     * @param \AppBundle\Entity\Cour $professeurDe
     */
    public function removeProfesseurDe(Cour $professeurDe)
    {
        $this->professeurDe->removeElement($professeurDe);
    }

    /**
     * Get professeurDe
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @param integer $estProfesseur
     *
     * @return Utilisateur
     */
    public function setEstProfesseur($estProfesseur)
    {
        //si pas sous utilisateur
        if(count($this->getParents()) == 0)
            $this->est_professeur = $estProfesseur;

        return $this;
    }

    /**
     * Get estProfesseur
     *
     * @return integer
     */
    public function getEstProfesseur()
    {
        return $this->est_professeur;
    }

    /**
     * Add sousUtilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $sousUtilisateur
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
     * @param \AppBundle\Entity\Utilisateur $sousUtilisateur
     */
    public function removeSousUtilisateur(Utilisateur $sousUtilisateur)
    {
        $this->sousUtilisateurs->removeElement($sousUtilisateur);
    }

    /**
     * Get sousUtilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSousUtilisateurs()
    {
        return $this->sousUtilisateurs;
    }


    /**
     * Add parent
     *
     * @param \AppBundle\Entity\Utilisateur $parent
     *
     * @return Utilisateur
     */
    public function addParent(Utilisateur $parent)
    {
        $this->parents[] = $parent;

        return $this;
    }

    /**
     * Remove parent
     *
     * @param \AppBundle\Entity\Utilisateur $parent
     */
    public function removeParent(Utilisateur $parent)
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
     * Add auteurDe
     *
     * @param \AppBundle\Entity\Contenu $auteurDe
     *
     * @return Utilisateur
     */
    public function addAuteurDe(Contenu $auteurDe)
    {
        $this->auteurDe[] = $auteurDe;

        return $this;
    }

    /**
     * Remove auteurDe
     *
     * @param \AppBundle\Entity\Contenu $auteurDe
     */
    public function removeAuteurDe(Contenu $auteurDe)
    {
        $this->auteurDe->removeElement($auteurDe);
    }

    /**
     * Get auteurDe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAuteurDe()
    {
        return $this->auteurDe;
    }

    /**
     * Add atelierSupervise
     *
     * @param \AppBundle\Entity\Atelier $atelierSupervise
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
     * @param \AppBundle\Entity\Atelier $atelierSupervise
     */
    public function removeAtelierSupervise(Atelier $atelierSupervise)
    {
        $this->atelierSupervise->removeElement($atelierSupervise);
    }

    /**
     * Get atelierSupervise
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAtelierSupervise()
    {
        return $this->atelierSupervise;
    }

    /**
     * Add evenementSupervise
     *
     * @param \AppBundle\Entity\Evenement $evenementSupervise
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
     * @param \AppBundle\Entity\Evenement $evenementSupervise
     */
    public function removeEvenementSupervise(Evenement $evenementSupervise)
    {
        $this->evenementSupervise->removeElement($evenementSupervise);
    }

    /**
     * Get evenementSupervise
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementSupervise()
    {
        return $this->evenementSupervise;
    }

    /**
     * Add sortieSupervise
     *
     * @param \AppBundle\Entity\Sortie $sortieSupervise
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
     * @param \AppBundle\Entity\Sortie $sortieSupervise
     */
    public function removeSortieSupervise(Sortie $sortieSupervise)
    {
        $this->sortieSupervise->removeElement($sortieSupervise);
    }

    /**
     * Get sortieSupervise
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSortieSupervise()
    {
        return $this->sortieSupervise;
    }

    /**
     * Add inscription
     *
     * @param \AppBundle\Entity\Inscription $inscription
     *
     * @return Utilisateur
     */
    public function addInscription(Inscription $inscription)
    {
        $this->inscriptions[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription
     *
     * @param \AppBundle\Entity\Inscription $inscription
     */
    public function removeInscription(Inscription $inscription)
    {
        $this->inscriptions->removeElement($inscription);
    }

    /**
     * Get inscriptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * Set locked
     *
     * @param integer $locked
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
     * @return integer
     */
    public function getLocked()
    {
        return $this->locked;
    }


    public function __toString()
    {
        $sAffichage = $this->getNom().' '.$this->getPrenom();
        if(empty(trim($sAffichage)) && !empty($this->getUsername())) {
            $sAffichage = "(Non-configuré) -> ".$this->getUsername();
        } else {
            $sAffichage = '';
        }
        return $sAffichage;
    }
}
