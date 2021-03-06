<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;

/**
 * Cour
 *
 * @ORM\Table(name="cour", indexes={
 *     @ORM\Index(name="ancre", columns={"ancre"}),
 *     @ORM\Index(name="slug", columns={"slug"}),
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
     * @var string
     *
     * @ORM\Column(name="lien_inscription", type="string", length=255, nullable=true)
     */
    private $lienInscription;

    /**
     * @var string
     *
     * @ORM\Column(name="lien_pdf", type="string", length=255, nullable=true)
     */
    private $lienPdf;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     message="basic_word"
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
     * @var string
     *
     * @ORM\Column(name="titre_nav", type="string", length=255)
     */
    private $titreNav;

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
     * @ORM\Column(name="creneau", type="string", length=255, nullable=true)
     */
    private $creneau;

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
     * @ORM\OneToMany(targetEntity="CourDetail", mappedBy="cours", cascade={"all"})
     */
    private $details;

    /**
     * @var CourDate
     * @ORM\OneToMany(targetEntity="CourDate", mappedBy="cours", cascade={"all"})
     */
    private $dates;

    /**
     * @var CourReport
     * @ORM\OneToMany(targetEntity="CourReport", mappedBy="cours", cascade={"persist"})
     */
    private $reports;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove", "refresh"}, fetch="LAZY")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=6, nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=60, nullable=true)
     */
    private $ville;

    /**
     * @var float
     *
     * @ORM\Column(name="coord_geo_latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $coordGeoLatitude;

    /**
     * @var float
     *
     * @ORM\Column(name="coord_geo_longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $coordGeoLongitude;


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
     * Set annule
     *
     * @param boolean $annule
     *
     * @return Cour
     */
    public function setAnnule($annule): Cour
    {
        $this->annule = $annule;

        return $this;
    }

    /**
     * Get annule
     *
     * @return boolean
     */
    public function getAnnule():? bool
    {
        return $this->annule;
    }

    /**
     * @param int $version
     *
     * @return Cour
     */
    public function setVersion($version): Cour
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return int
     */
    public function getVersion():? int
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
    public function setAffiche($affiche): Cour
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
     * Add inscrit
     *
     * @param Utilisateur $inscrits
     *
     * @return Cour
     */
    public function addInscrit(Utilisateur $inscrits): Cour
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
    public function addProfesseur(Utilisateur $professeur): Cour
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
    public function setSlug($slug): Cour
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
    public function setTimestampCreation($timestampCreation): Cour
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
     * @return Cour
     */
    public function setTimestampModification($timestampModification): Cour
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
     * @return bool
     */
    public function isBientotComplet():? bool
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
    public function getLienInscription():? string
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
    public function getLienPdf():? string
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
    public function getAncre():? string
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
    public function getTitre():? string
    {
        return $this->titre;
    }

    /**
     * @param string $titreNav
     */
    public function setTitreNav($titreNav)
    {
        $this->titreNav = $titreNav;
    }

    /**
     * @return string
     */
    public function getTitreNav():? string
    {
        return $this->titreNav;
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
    public function getPrix():? float
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
    public function getAmorce():? string
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
    public function getCreneau():? string
    {
        return $this->creneau;
    }

    /**
     * @param string $creneau
     */
    public function setCreneau($creneau)
    {
        $this->creneau = $creneau;
    }

    /**
     * @return string
     */
    public function getConditionParticuliere():? string
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
    public function getNote():? string
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
    public function setImage(MediaInterface $image = null): Cour
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
     * @return string
     */
    public function getMessageAnnulation():? string
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
    public function addDetail(CourDetail $detail): Cour
    {
        $this->details[] = $detail;

        return $this;
    }

    /**
     * Remove detail
     *
     * @param CourDetail $detail
     */
    public function removeDetail(CourDetail $detail)
    {
        $detail->setCours(null);
        $this->details->removeElement($detail);
    }

    /**
     * @return CourDate
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param CourDate $dates
     */
    public function setDates(CourDate $dates)
    {
        $this->dates = $dates;
    }

    /**
     * Add date
     *
     * @param CourDate $date
     *
     * @return Cour
     */
    public function addDate(CourDate $date): Cour
    {
        $this->dates[] = $date;

        return $this;
    }

    /**
     * Remove date
     *
     * @param CourDate $date
     */
    public function removeDate(CourDate $date)
    {
        $date->setCours(null);
        $this->dates->removeElement($date);
    }

    /**
     * @return CourReport
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * @param CourReport $reports
     */
    public function setReports(CourReport $reports)
    {
        $this->reports = $reports;
    }

    /**
     * Add report
     *
     * @param CourReport $report
     *
     * @return Cour
     */
    public function addReport(CourReport $report): Cour
    {
        $this->reports[] = $report;

        return $this;
    }

    /**
     * Remove report
     *
     * @param CourReport $report
     */
    public function removeReport(CourReport $report)
    {
        $this->reports->removeElement($report);
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Cour
     */
    public function setAdresse($adresse): Cour
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse():? string
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Cour
     */
    public function setCodePostal($codePostal): Cour
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal():? string
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Cour
     */
    public function setVille($ville): Cour
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille():? string
    {
        return $this->ville;
    }

    /**
     * Set coordGeoLatitude
     *
     * @param float $coordGeoLatitude
     *
     * @return Cour
     */
    public function setCoordGeoLatitude($coordGeoLatitude): Cour
    {
        $this->coordGeoLatitude = $coordGeoLatitude;

        return $this;
    }

    /**
     * Get coordGeoLatitude
     *
     * @return float
     */
    public function getCoordGeoLatitude():? float
    {
        return $this->coordGeoLatitude;
    }

    /**
     * Set coordGeoLongitude
     *
     * @param float $coordGeoLongitude
     *
     * @return Cour
     */
    public function setCoordGeoLongitude($coordGeoLongitude): Cour
    {
        $this->coordGeoLongitude = $coordGeoLongitude;

        return $this;
    }

    /**
     * Get coordGeoLongitude
     *
     * @return float
     */
    public function getCoordGeoLongitude():? float
    {
        return $this->coordGeoLongitude;
    }

    /**
     * @param $latlng
     * @return $this
     */
    public function setLatLng($latlng): Cour
    {
        $this->setCoordGeoLatitude($latlng['lat']);
        $this->setCoordGeoLongitude($latlng['lng']);

        return $this;
    }

    /**
     * @Assert\NotBlank()
     * @OhAssert\LatLng()
     * @return array
     */
    public function getLatLng(): array
    {
        return array('lat' => $this->getCoordGeoLatitude(), 'lng' => $this->getCoordGeoLongitude());
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->getAdresse().', '.$this->getCodePostal().' '.$this->getVille();
    }
}
