<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DateCalendrier
 *
 * @ORM\Table(name="date_calendrier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DateCalendrierRepository")
 */
class DateCalendrier
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
	
    /**
     * @ORM\ManyToMany(targetEntity="Cour", mappedBy="dates")
     */
    private $cours;
	
    /**
     * @ORM\OneToMany(targetEntity="Atelier", mappedBy="date")
     */
    private $ateliers;
    
    /**
     * @ORM\OneToMany(targetEntity="Atelier", mappedBy="date_limite")
     */
    private $ateliers_limite;
    
    /**
     * @ORM\OneToMany(targetEntity="Sortie", mappedBy="date")
     */
    private $sorties;
    
    /**
     * @ORM\OneToMany(targetEntity="Sortie", mappedBy="date_limite")
     */
    private $sorties_limite;
	
	/**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="date")
     */
    private $evenements;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DateCalendrier
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cours        = new ArrayCollection();
        $this->ateliers     = new ArrayCollection();
        $this->evenements   = new ArrayCollection();
        $this->setDate(new \DateTime());
    }

    /**
     * Add cour
     *
     * @param \AppBundle\Entity\Cour $cour
     *
     * @return DateCalendrier
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
     * Add atelier
     *
     * @param \AppBundle\Entity\Atelier $atelier
     *
     * @return DateCalendrier
     */
    public function addAtelier(Atelier $atelier)
    {
        $this->ateliers[] = $atelier;

        return $this;
    }

    /**
     * Remove atelier
     *
     * @param \AppBundle\Entity\Atelier $atelier
     */
    public function removeAtelier(Atelier $atelier)
    {
        $this->ateliers->removeElement($atelier);
    }

    /**
     * Get ateliers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAteliers()
    {
        return $this->ateliers;
    }

    /**
     * Add evenement
     *
     * @param \AppBundle\Entity\Evenement $evenement
     *
     * @return DateCalendrier
     */
    public function addEvenement(Evenement $evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * Remove evenement
     *
     * @param \AppBundle\Entity\Evenement $evenement
     */
    public function removeEvenement(Evenement $evenement)
    {
        $this->evenements->removeElement($evenement);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * Add ateliersLimite
     *
     * @param \AppBundle\Entity\Atelier $ateliersLimite
     *
     * @return DateCalendrier
     */
    public function addAteliersLimite(Atelier $ateliersLimite)
    {
        $this->ateliers_limite[] = $ateliersLimite;

        return $this;
    }

    /**
     * Remove ateliersLimite
     *
     * @param \AppBundle\Entity\Atelier $ateliersLimite
     */
    public function removeAteliersLimite(Atelier $ateliersLimite)
    {
        $this->ateliers_limite->removeElement($ateliersLimite);
    }

    /**
     * Get ateliersLimite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAteliersLimite()
    {
        return $this->ateliers_limite;
    }

    /**
     * Add sorty
     *
     * @param \AppBundle\Entity\Sortie $sorty
     *
     * @return DateCalendrier
     */
    public function addSorty(Sortie $sorty)
    {
        $this->sorties[] = $sorty;

        return $this;
    }

    /**
     * Remove sorty
     *
     * @param \AppBundle\Entity\Sortie $sorty
     */
    public function removeSorty(Sortie $sorty)
    {
        $this->sorties->removeElement($sorty);
    }

    /**
     * Get sorties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSorties()
    {
        return $this->sorties;
    }

    /**
     * Add sortiesLimite
     *
     * @param \AppBundle\Entity\Sortie $sortiesLimite
     *
     * @return DateCalendrier
     */
    public function addSortiesLimite(Sortie $sortiesLimite)
    {
        $this->sorties_limite[] = $sortiesLimite;

        return $this;
    }

    /**
     * Remove sortiesLimite
     *
     * @param \AppBundle\Entity\Sortie $sortiesLimite
     */
    public function removeSortiesLimite(Sortie $sortiesLimite)
    {
        $this->sorties_limite->removeElement($sortiesLimite);
    }

    /**
     * Get sortiesLimite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSortiesLimite()
    {
        return $this->sorties_limite;
    }
}
