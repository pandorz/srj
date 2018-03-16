<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourDate
 *
 * @ORM\Table(name="cour_date")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourDateRepository")
 */
class CourDate
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true))
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="jour", type="integer", nullable=false)
     */
    private $jour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_debut", type="time", nullable=false)
     */
    private $heureDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_fin", type="time", nullable=false)
     */
    private $heureFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var int
     *
     * @ORM\Column(name="repetition", type="integer", nullable=false)
     */
    private $repetition;

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
     * @ORM\ManyToOne(targetEntity="Cour", inversedBy="dates")
     * @ORM\JoinColumn(name="fk_cour", referencedColumnName="id", nullable=true)
     */
    private $cours;

    /**
     * CourDate constructor.
     */
    public function __construct()
    {
        $this->jour = 0;
        $this->heureDebut = new \DateTime();
        $this->heureFin = new \DateTime();
        $this->date = new \DateTime();
        $this->repetition = 1;
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
     * @return int
     */
    public function getJour():? int
    {
        return $this->jour;
    }

    /**
     * @param int $jour
     */
    public function setJour(int $jour)
    {
        $this->jour = $jour;
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
    public function getCours(): Cour
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
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getJourFr(): string
    {
        switch ($this->jour) {
            case 0:
                return 'Dimanche';
                break;
            case 1:
                return 'Lundi';
                break;
            case 2:
                return 'Mardi';
                break;
            case 3:
                return 'Mercredi';
                break;
            case 4:
                return 'Jeudi';
                break;
            case 5:
                return 'Vendredi';
                break;
            case 6:
                return 'Samedi';
                break;
        }
    }

    /**
     * @return string
     */
    public function getRepetitionFr(): string
    {
        switch ($this->repetition) {
            case 0:
                return 'Aucune répétition';
                break;
            case 1:
                return 'Toutes les semaines';
                break;
            case 2:
                return 'Toutes les deux semaines';
                break;
        }
    }

    /**
     * @return \DateTime
     */
    public function getDate():? \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getRepetition():? int
    {
        return $this->repetition;
    }

    /**
     * @param int $repetition
     */
    public function setRepetition(int $repetition)
    {
        $this->repetition = $repetition;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin():? \DateTime
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin(\DateTime $dateFin)
    {
        $this->dateFin = $dateFin;
    }
}