<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Model\MediaInterface;
use Eko\FeedBundle\Item\Writer\RoutedItemInterface;
use Sonata\MediaBundle\Provider\ImageProvider;

/**
 * Blog
 *
 * @ORM\Table(name="blog", indexes={
 *     @ORM\Index(name="nom", columns={"nom"}),
 *     @ORM\Index(name="slug", columns={"slug"}),
 *     @ORM\Index(name="affiche", columns={"affiche"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BlogRepository")
 */
class Blog implements RoutedItemInterface
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
     * @ORM\joinColumn(onDelete="SET NULL")
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
     * @var array
     *
     * @ORM\Column(name="current_place", type="json_array", nullable=true)
     */
    private $currentPlace;

    /**
     * For Sonata Admin Doctrine lock
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Version
     */
    protected $version;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="auteurDe")
     * @ORM\JoinTable(name="blog_auteurs",
     *     joinColumns={@ORM\JoinColumn(name="blog_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $auteurs;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="blogs")
     * @ORM\JoinTable(name="blog_tags",
     *     joinColumns={@ORM\JoinColumn(name="blog_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $tags;

    /**
     * Get id
     *
     * @return int
     */
    public function getId():? int
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
    public function setNom($nom): Blog
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom():? string
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getDescriptionCourte():? string
    {
        return $this->descriptionCourte;
    }

    /**
     * @param string $descriptionCourte
     *
     *  @return Blog
     */
    public function setDescriptionCourte($descriptionCourte): Blog
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
    public function setAffiche($affiche): Blog
    {
        $this->affiche = $affiche;

        return $this;
    }

    /**
     * Get affiche
     *
     * @return boolean
     */
    public function getAffiche():? bool
    {
        return $this->affiche;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->affiche = true;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Blog
     */
    public function setSlug($slug): Blog
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug():? string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getVersion():? int
    {
        return $this->version;
    }

    /**
     * @param int $version
     *
     * @return Blog
     */
    public function setVersion($version): Blog
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
    public function setImage(MediaInterface $image = null): Blog
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return MediaInterface
     */
    public function getImage():? MediaInterface
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
    public function setContenu($contenu): Blog
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu():? string
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
    public function getTimestampCreation():? \DateTime
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
    public function setTimestampModification($timestampModification): Blog
    {
        $this->timestampModification = $timestampModification;

        return $this;
    }

    /**
     * Get timestampModification
     *
     * @return \DateTime
     */
    public function getTimestampModification():? \DateTime
    {
        return $this->timestampModification;
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
     * @return \DateTime
     */
    public function getDatePublication():? \DateTime
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

    /**
     * Add auteur
     *
     * @param Utilisateur $auteur
     *
     * @return Blog
     */
    public function addAuteur(Utilisateur $auteur): Blog
    {
        $this->auteurs[] = $auteur;

        return $this;
    }

    /**
     * Remove auteur
     *
     * @param Utilisateur $auteur
     */
    public function removeAuteur(Utilisateur $auteur)
    {
        $this->auteurs->removeElement($auteur);
    }

    /**
     * Get auteurs
     *
     * @return ArrayCollection
     */
    public function getAuteurs()
    {
        return $this->auteurs;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     *
     * @return Blog
     */
    public function addTag(Tag $tag): Blog
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    // Flux rss
    public function getFeedItemTitle()
    {
        return $this->getNom();
    }

    public function getFeedItemDescription()
    {
        $this->getDescriptionCourte();
    }

    public function getFeedItemRouteName()
    {
        return 'blog_detail';
    }

    public function getFeedItemRouteParameters()
    {
        return ['slug' => $this->getSlug()];
    }

    public function getFeedItemPubDate()
    {
        return $this->getDatePublication();
    }

    public function getFeedItemUrlAnchor()
    {
        return null;
    }

    /**
     * @return array
     */
    public function getCurrentPlace():? array
    {
        return $this->currentPlace;
    }

    /**
     * @param array $currentPlace
     */
    public function setCurrentPlace(array $currentPlace)
    {
        $this->currentPlace = $currentPlace;
    }
}