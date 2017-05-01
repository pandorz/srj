<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Atelier
 *
 * @ORM\Table(name="atelier")
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
    * @Gedmo\Slug(fields={"nom"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="affiche", type="integer")
     */
    private $affiche;

    /**
     * @var int
     *
     * @ORM\Column(name="annule", type="integer")
     */
    private $annule;
	
    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="atelier")
     */
    private $inscriptions;
	
    /**
     *
     * @ORM\ManyToOne(targetEntity="DateCalendrier", inversedBy="ateliers")
     * @ORM\JoinColumn(nullable=false, name="fk_date", referencedColumnName="id")
     */
    private $date;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="DateCalendrier", inversedBy="ateliers_limite")
     * @ORM\JoinColumn(nullable=false, name="fk_date_limite", referencedColumnName="id")
     */
    private $date_limite;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nb_place", type="integer")
     */
    private $nbPlace;
    
    /**
    * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist"})
    */

   private $image;
   
    /**
     * @ORM\OneToMany(targetEntity="Contenu", mappedBy="atelier")
     */
    private $contenu;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="atelierSupervise")
     */
    private $superviseurs;
    
    /**
     * @var int
     *
     * @ORM\Column(name="reserveMembre", type="integer")
     */
    private $reserveMembre;
    
    /**
     * @var double
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;


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
     * @return Atelier
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
     * @param integer $affiche
     *
     * @return Atelier
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
     * Set annule
     *
     * @param integer $annule
     *
     * @return Atelier
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
     * Constructor
     */
    public function __construct()
    {
        $this->annule           = 0;
        $this->affiche          = 1;
        $this->superviseurs     = new ArrayCollection();
        $this->reserveMembre    = 0;
        $this->prix             = 0;
    }


    /**
     * Set date
     *
     * @param \AppBundle\Entity\DateCalendrier $date
     *
     * @return Atelier
     */
    public function setDate(DateCalendrier $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \AppBundle\Entity\DateCalendrier
     */
    public function getDate()
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
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Atelier
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
     * Set dateLimite
     *
     * @param \AppBundle\Entity\DateCalendrier $dateLimite
     *
     * @return Atelier
     */
    public function setDateLimite(DateCalendrier $dateLimite)
    {
        $this->date_limite = $dateLimite;

        return $this;
    }

    /**
     * Get dateLimite
     *
     * @return \AppBundle\Entity\DateCalendrier
     */
    public function getDateLimite()
    {
        return $this->date_limite;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Atelier
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
     * Add contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return Atelier
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
     * Add inscription
     *
     * @param \AppBundle\Entity\Inscription $inscription
     *
     * @return Atelier
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
     * Add superviseur
     *
     * @param \AppBundle\Entity\Utilisateur $superviseur
     *
     * @return Atelier
     */
    public function addSuperviseur(Utilisateur $superviseur)
    {
        $this->superviseurs[] = $superviseur;

        return $this;
    }

    /**
     * Remove superviseur
     *
     * @param \AppBundle\Entity\Utilisateur $superviseur
     */
    public function removeSuperviseur(Utilisateur $superviseur)
    {
        $this->superviseurs->removeElement($superviseur);
    }

    /**
     * Get superviseurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuperviseurs()
    {
        return $this->superviseurs;
    }

    /**
     * Set reserveMembre
     *
     * @param integer $reserveMembre
     *
     * @return Atelier
     */
    public function setReserveMembre($reserveMembre)
    {
        $this->reserveMembre = $reserveMembre;

        return $this;
    }

    /**
     * Get reserveMembre
     *
     * @return integer
     */
    public function getReserveMembre()
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
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }
}
