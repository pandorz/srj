<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Blog
 *
 * @ORM\Table(name="blog", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="affiche", columns={"affiche"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BlogRepository")
 */
class Blog
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
     * @ORM\Column(name="description_courte", type="string", length=255)
     */
    private $descriptionCourte;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="affiche", type="boolean")
     */
    private $affiche;        

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime", nullable=true)
     */
    private $datePublication;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove", "refresh"}, fetch="LAZY")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
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
     * For Sonata Admin Doctrine lock
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Version
     */
    protected $version;

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
     * @return Blog
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
     * @return mixed
     */
    public function getDescriptionCourte()
    {
        return $this->descriptionCourte;
    }

    /**
     * @param string $descriptionCourte
     *
     *  @return Blog
     */
    public function setDescriptionCourte($descriptionCourte)
    {
        $this->descriptionCourte = $descriptionCourte;

        return $this;
    }

    /**
     * Set affiche
     *
     * @param boolean $affiche
     *
     * @return Blog
     */
    public function setAffiche($affiche)
    {
        $this->affiche = $affiche;

        return $this;
    }

    /**
     * Get affiche
     *
     * @return boolean
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
        $this->affiche      = true;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Blog
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
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param int $version
     *
     * @return Blog
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set image
     *
     * @param MediaInterface $image
     *
     * @return Blog
     */
    public function setImage(MediaInterface $image = null)
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

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Blog
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
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
     * @return Blog
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
     * @return Blog
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

    /**
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * @param \DateTime $datePublication
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    }

}