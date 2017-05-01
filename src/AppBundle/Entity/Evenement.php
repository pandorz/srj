<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvenementRepository")
 */
class Evenement
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
     *
     * @ORM\ManyToOne(targetEntity="DateCalendrier", inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false, name="fk_date", referencedColumnName="id")
     */
    private $date;
    
    /**
    * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist"})
    */

   private $image;
   
   /**
     * @ORM\OneToMany(targetEntity="Contenu", mappedBy="evenement")
     */
    private $contenu;

    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="evenementSupervise")
     */
    private $superviseurs;

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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
        $this->annule       = 0;
        $this->affiche      = 1;
        $this->superviseurs = new ArrayCollection();
    }



    /**
     * Set date
     *
     * @param \AppBundle\Entity\DateCalendrier $date
     *
     * @return Evenement
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
     * @return Evenement
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
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Evenement
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
     * @return Evenement
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
     * Add superviseur
     *
     * @param \AppBundle\Entity\Utilisateur $superviseur
     *
     * @return Evenement
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
}
