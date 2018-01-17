<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tag
 * @ORM\Table(name="tag", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="slug", columns={"slug"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
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
     * @ORM\Column(name="nom", type="string", unique=true, length=100)
     */
    private $nom;
    
   /**
    * @var string
    *
    * @Gedmo\Slug(fields={"nom"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Blog", mappedBy="tags")
     */
    private $blogs;
    
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
     * Tag constructor.
     */
    public function __construct()
    {
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Tag
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Tag
     */
    public function setNom($nom)
    {
        $this->nom = mb_strtolower($nom);

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
     * @return Tag
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
     * @return Tag
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

    public function __toString()
    {
        return (!is_null($this->nom)?$this->nom:"");
    }

    /**
     * Add blog
     *
     * @param Blog $blog
     *
     * @return Tag
     */
    public function addBlog(Blog $blog)
    {
        $this->blogs[] = $blog;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    /**
     * Remove blog
     *
     * @param Blog $blog
     */
    public function removeAuteurDe(Blog $blog)
    {
        $this->blogs->removeElement($blog);
    }

    /**
     * Get blogs
     *
     * @return ArrayCollection
     */
    public function getAuteurDe()
    {
        return $this->blogs;
    }
}
