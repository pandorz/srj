<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscription
 *
 * @ORM\Table(name="inscription")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InscriptionRepository")
 */
class Inscription
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
     * @var int
     *
     * @ORM\Column(name="nbPlace", type="integer", nullable=false)
     */
    private $nbPlace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false, name="fk_utilisateur", referencedColumnName="id")
     */
    private $utilisateur;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Sortie", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=true, name="fk_sortie", referencedColumnName="id")
     */
    private $sortie;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Atelier", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=true, name="fk_atelier", referencedColumnName="id")
     */
    private $atelier;

    
    
    
    /**
    * Constructor
    */
    public function __construct() 
    {
        $this->dateCreation = new \DateTime();
        $this->nbPlace      = 1;
    }


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
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Inscription
     */
    public function setNbPlace($nbPlace)
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get nbPlace
     *
     * @return int
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Inscription
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return Inscription
     */
    public function setUtilisateur(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set sortie
     *
     * @param \AppBundle\Entity\Sortie $sortie
     *
     * @return Inscription
     */
    public function setSortie(Sortie $sortie = null)
    {
        $this->sortie = $sortie;

        return $this;
    }

    /**
     * Get sortie
     *
     * @return \AppBundle\Entity\Sortie
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * Set atelier
     *
     * @param \AppBundle\Entity\Atelier $atelier
     *
     * @return Inscription
     */
    public function setAtelier(Atelier $atelier = null)
    {
        $this->atelier = $atelier;

        return $this;
    }

    /**
     * Get atelier
     *
     * @return \AppBundle\Entity\Atelier
     */
    public function getAtelier()
    {
        return $this->atelier;
    }
}
