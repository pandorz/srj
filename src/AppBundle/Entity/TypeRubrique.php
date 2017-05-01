<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TypeRubrique
 *
 * @ORM\Table(name="type_rubrique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeRubriqueRepository")
 */
class TypeRubrique
{
    /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
    private $id;

	/**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;
	
	/**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;
	

    /**
     * @ORM\OneToMany(targetEntity="Rubrique", mappedBy="type")
     */
    private $rubriques;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rubriques = new ArrayCollection();
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
     * @return TypeRubrique
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
     * Add rubrique
     *
     * @param \AppBundle\Entity\Rubrique $rubrique
     *
     * @return TypeRubrique
     */
    public function addRubrique(Rubrique $rubrique)
    {
        $this->rubriques[] = $rubrique;

        return $this;
    }

    /**
     * Remove rubrique
     *
     * @param \AppBundle\Entity\Rubrique $rubrique
     */
    public function removeRubrique(Rubrique $rubrique)
    {
        $this->rubriques->removeElement($rubrique);
    }

    /**
     * Get rubriques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRubriques()
    {
        return $this->rubriques;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return TypeRubrique
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Affichage libelle
     * @return string
     */
    public function __toString()
    {
        $sAffichage = $this->getLibelle();   
        return $sAffichage;
    }
}
