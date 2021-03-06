<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourDetail
 *
 * @ORM\Table(name="cour_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourDetailRepository")
 */
class CourDetail
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
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255, nullable=true)
     */
    private $contenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="complet", type="boolean")
     */
    private $complet;

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
     * @var Cour
     * @ORM\ManyToOne(targetEntity="Cour", inversedBy="details")
     * @ORM\JoinColumn(name="fk_cour", referencedColumnName="id", onDelete="SET NULL")
     */
    private $cours;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom():? string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getContenu():? string
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return bool
     */
    public function isComplet():? bool
    {
        return $this->complet;
    }

    /**
     * @param bool $complet
     */
    public function setComplet($complet)
    {
        $this->complet = $complet;
    }

    /**
     * @return \DateTime
     */
    public function getTimestampCreation():? \DateTime
    {
        return $this->timestampCreation;
    }

    /**
     * @param \DateTime $timestampCreation
     */
    public function setTimestampCreation($timestampCreation)
    {
        $this->timestampCreation = $timestampCreation;
    }

    /**
     * @return \DateTime
     */
    public function getTimestampModification():? \DateTime
    {
        return $this->timestampModification;
    }

    /**
     * @param \DateTime $timestampModification
     */
    public function setTimestampModification($timestampModification)
    {
        $this->timestampModification = $timestampModification;
    }

    /**
     * @return string
     */
    public function getUtilisateurCreation():? string
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
    public function getUtilisateurModification():? string
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
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return Cour
     */
    public function getCours():? Cour
    {
        return $this->cours;
    }

    /**
     * @param Cour $cours
     */
    public function setCours(Cour $cours = null)
    {
        $this->cours = $cours;
    }

    /**
     * @return null|string
     */
    public function __toString():? string
    {
        return $this->nom;
    }
}