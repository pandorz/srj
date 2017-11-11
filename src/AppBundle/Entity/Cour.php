<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Cour
 *
 * @ORM\Table(name="cour", indexes={
 *     @ORM\Index(name="ancre", columns={"ancre"}),
 *     @ORM\Index(name="affiche", columns={"affiche"}),
 *     @ORM\Index(name="annule", columns={"annule"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourRepository")
 */
class Cour
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
    * @Gedmo\Slug(fields={"titre"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="annule", type="boolean")
     */
    private $annule;

    /**
     * @var string
     *
     * @ORM\Column(name="message_annulation", type="string", length=255, nullable=true)
     */
    private $messageAnnulation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="complet", type="boolean")
     */
    private $complet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bientot_complet", type="boolean")
     */
    private $bientotComplet;

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
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="cours")
     * @ORM\JoinTable(name="cours_inscriptions",
     *     joinColumns={@ORM\JoinColumn(name="cour_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $inscrits;

    /**
     * @var Parametre
     *
     * @ORM\Column(name="lien_inscription", type="string", length=255, nullable=true)
     */
    private $lienInscription;

    /**
     * @var Parametre
     *
     * @ORM\Column(name="lien_pdf", type="string", length=255, nullable=true)
     */
    private $lienPdf;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     message="Seulement un mot, sans accents"
     * )
     * @ORM\Column(name="ancre", type="string", length=45)
     */
    private $ancre;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var double
     *
     * @ORM\Column(name="prix", type="float", nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="amorce", type="text", length=65535, nullable=true)
     */
    private $amorce;

    /**
     * @var string
     *
     * @ORM\Column(name="crenau", type="string", length=255, nullable=true)
     */
    private $crenau;

    /**
     * @var string
     *
     * @ORM\Column(name="condition_particuliere", type="string", length=255, nullable=true)
     */
    private $conditionParticuliere;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="professeurDe")
     * @ORM\JoinTable(name="cours_professeurs",
     *     joinColumns={@ORM\JoinColumn(name="cour_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")}
     * )
     */
    private $professeurs;
    
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
     * @var CourDetail
     * @ORM\OneToMany(targetEntity="CourDetail", mappedBy="cours", cascade={"persist"})
     */
    private $details;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove", "refresh"}, fetch="LAZY")
     */
    private $image;


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
     * Set annule
     *
     * @param boolean $annule
     *
     * @return Cour
     */
    public function setAnnule($annule)
    {
        $this->annule = $annule;

        return $this;
    }

    /**
     * Get annule
     *
     * @return boolean
     */
    public function getAnnule()
    {
        return $this->annule;
    }
    
    /**
     * @param int $version
     * 
     * @return Cour
     */
    public function setVersion($version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set affiche
     *
     * @param boolean $affiche
     *
     * @return Cour
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
     * Add inscrit
     *
     * @param Utilisateur $inscrits
     *
     * @return Cour
     */
    public function addInscrit(Utilisateur $inscrits)
    {
        $this->inscrits[] = $inscrits;

        return $this;
    }

    /**
     * Remove inscrit
     *
     * @param Utilisateur $inscrits
     */
    public function removeInscrit(Utilisateur $inscrits)
    {
        $this->inscrits->removeElement($inscrits);
    }

    /**
     * Get inscrits
     *
     * @return ArrayCollection
     */
    public function getInscrits()
    {
        return $this->inscrits;
    }

    /**
     * Add professeur
     *
     * @param Utilisateur $professeur
     *
     * @return Cour
     */
    public function addProfesseur(Utilisateur $professeur)
    {
        $this->professeurs[] = $professeur;

        return $this;
    }

    /**
     * Remove professeur
     *
     * @param Utilisateur $professeur
     */
    public function removeProfesseur(Utilisateur $professeur)
    {
        $this->professeurs->removeElement($professeur);
    }

    /**
     * Get professeurs
     *
     * @return ArrayCollection
     */
    public function getProfesseurs()
    {
        return $this->professeurs;
    }


    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Cour
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
     * @return Cour
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
     * @return Cour
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

    /**
     * @return bool
     */
    public function isComplet()
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
     * @return bool
     */
    public function isBientotComplet()
    {
        return $this->bientotComplet;
    }

    /**
     * @param bool $bientotComplet
     */
    public function setBientotComplet($bientotComplet)
    {
        $this->bientotComplet = $bientotComplet;
    }

    /**
     * @return string
     */
    public function getLienInscription()
    {
        return $this->lienInscription;
    }

    /**
     * @param string $lienInscription
     */
    public function setLienInscription($lienInscription)
    {
        $this->lienInscription = $lienInscription;
    }

    /**
     * @return string
     */
    public function getLienPdf()
    {
        return $this->lienPdf;
    }

    /**
     * @param string $lienPdf
     */
    public function setLienPdf($lienPdf)
    {
        $this->lienPdf = $lienPdf;
    }

    /**
     * @return string
     */
    public function getAncre()
    {
        return $this->ancre;
    }

    /**
     * @param string $ancre
     */
    public function setAncre($ancre)
    {
        $this->ancre = $ancre;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getAmorce()
    {
        return $this->amorce;
    }

    /**
     * @param string $amorce
     */
    public function setAmorce($amorce)
    {
        $this->amorce = $amorce;
    }

    /**
     * @return string
     */
    public function getCrenau()
    {
        return $this->crenau;
    }

    /**
     * @param string $crenau
     */
    public function setCrenau($crenau)
    {
        $this->crenau = $crenau;
    }

    /**
     * @return string
     */
    public function getConditionParticuliere()
    {
        return $this->conditionParticuliere;
    }

    /**
     * @param string $conditionParticuliere
     */
    public function setConditionParticuliere($conditionParticuliere)
    {
        $this->conditionParticuliere = $conditionParticuliere;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return CourDetail
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param CourDetail $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * Set image
     *
     * @param MediaInterface $image
     *
     * @return Cour
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
     * @return string
     */
    public function getMessageAnnulation()
    {
        return $this->messageAnnulation;
    }

    /**
     * @param string $messageAnnulation
     */
    public function setMessageAnnulation(string $messageAnnulation)
    {
        $this->messageAnnulation = $messageAnnulation;
    }

    /**
     * Add detail
     *
     * @param CourDetail $detail
     *
     * @return Cour
     */
    public function addDetail(CourDetail $detail)
    {
        $this->details[] = $detail;

        return $this;
    }

    /**
     * Remove superviseur
     *
     * @param CourDetail $detail
     */
    public function removeDetail(CourDetail $detail)
    {
        $this->details->removeElement($detail);
    }
}
