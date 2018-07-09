<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourReport
 *
 * @ORM\Table(name="cour_report")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourReportRepository")
 */
class CourReport
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
     * @ORM\Column(name="date_annule", type="date", nullable=true)
     */
    private $dateAnnule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_report", type="date", nullable=true)
     */
    private $dateReport;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_debut", type="time", nullable=true)
     */
    private $heureDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_fin", type="time", nullable=true)
     */
    private $heureFin;

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
     * @ORM\ManyToOne(targetEntity="Cour", inversedBy="reports")
     * @ORM\JoinColumn(name="fk_cour", referencedColumnName="id", nullable=true)
     */
    private $cours;

    /**
     * CourDate constructor.
     */
    public function __construct()
    {
        $this->heureDebut = new \DateTime();
        $this->heureFin = new \DateTime();
    }


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
     * @return \DateTime
     */
    public function getDateAnnule():? \DateTime
    {
        return $this->dateAnnule;
    }

    /**
     * @param \DateTime $dateAnnule
     */
    public function setDateAnnule(\DateTime $dateAnnule = null)
    {
        $this->dateAnnule = $dateAnnule;
    }

    /**
     * @return \DateTime
     */
    public function getDateReport():? \DateTime
    {
        return $this->dateReport;
    }

    /**
     * @param \DateTime $dateReport
     */
    public function setDateReport(\DateTime $dateReport)
    {
        $this->dateReport = $dateReport;
    }

    /**
     * @return \DateTime
     */
    public function getHeureDebut():? \DateTime
    {
        return $this->heureDebut;
    }

    /**
     * @param \DateTime $heureDebut
     */
    public function setHeureDebut(\DateTime $heureDebut)
    {
        $this->heureDebut = $heureDebut;
    }

    /**
     * @return \DateTime
     */
    public function getHeureFin():? \DateTime
    {
        return $this->heureFin;
    }

    /**
     * @param \DateTime $heureFin
     */
    public function setHeureFin(\DateTime $heureFin)
    {
        $this->heureFin = $heureFin;
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
    public function getVersion():? int
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
    public function setCours(Cour $cours)
    {
        $this->cours = $cours;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $string = "";
        if (!is_null($this->dateAnnule)) {
            $string = 'Cours annulé le '.$this->dateAnnule->format("d/m/Y");
        }

        if (!is_null($this->dateReport)) {
            if (empty($string)) {
                $string = 'Report le ' .$this->dateReport->format("d/m/Y");
            } else {
                $string.= ' reporté au '.$this->dateReport->format("d/m/Y");
            }
        }
        return $string;
    }
}