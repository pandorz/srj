<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilisateurLog
 * @ORM\Table(name="demande_acces")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeAccesRepository")
 */
class DemandeAcces
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
     * @ORM\Column(name="numero_membre", type="string", length=20, unique=true)
     */
    private $numeroMembre;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_creation", type="datetime")
     */
    private $timestampCreation;


    public function __construct()
    {
        $this->timestampCreation = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNumeroMembre():? string
    {
        return $this->numeroMembre;
    }

    /**
     * @param string $numeroMembre
     */
    public function setNumeroMembre(string $numeroMembre)
    {
        $this->numeroMembre = $numeroMembre;
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
    public function setTimestampCreation(\DateTime $timestampCreation)
    {
        $this->timestampCreation = $timestampCreation;
    }
}
