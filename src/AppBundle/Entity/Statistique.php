<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistique
 * @ORM\Table(name="statistique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatistiqueRepository")
 */
class Statistique
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
     * @ORM\Column(name="entity_name", type="string", length=255)
     */
    private $entityName;

    /**
     * @var int
     *
     * @ORM\Column(name="occurence", type="integer")
     */
    private $occurence;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_creation", type="date")
     */
    private $timestampCreation;


    public function __construct()
    {
        $this->timestampCreation = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
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
    public function getTimestampCreation()
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

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }

    /**
     * @return int
     */
    public function getOccurence()
    {
        return $this->occurence;
    }

    /**
     * @param int $occurence
     */
    public function setOccurence($occurence)
    {
        $this->occurence = $occurence;
    }
}
