<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilisateurLog
 * @ORM\Table(name="utilisateur_log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurLogRepository")
 */
class UtilisateurLog
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
     * @var int
     *
     * @ORM\Column(name="utilisateur_id", type="integer")
     */
    private $utilisateurId;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_membre", type="string", length=255, nullable=true)
     */
    private $numeroMembre;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_name", type="string", length=255)
     */
    private $entityName;

    /**
     * @var int
     *
     * @ORM\Column(name="entity_id", type="integer")
     */
    private $entityId;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_name", type="string", length=255)
     */
    private $eventType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_action", type="datetime")
     */
    private $dateAction;

    public function __construct()
    {
        $this->dateAction = new \DateTime();
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
     * @return int
     */
    public function getUtilisateurId()
    {
        return $this->utilisateurId;
    }

    /**
     * @param int $utilisateurId
     */
    public function setUtilisateurId($utilisateurId)
    {
        $this->utilisateurId = $utilisateurId;
    }

    /**
     * @return string
     */
    public function getNumeroMembre()
    {
        return $this->numeroMembre;
    }

    /**
     * @param string $numeroMembre
     */
    public function setNumeroMembre($numeroMembre)
    {
        $this->numeroMembre = $numeroMembre;
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
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param int $entityId
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @return \DateTime
     */
    public function getDateAction()
    {
        return $this->dateAction;
    }

    /**
     * @param \DateTime $dateAction
     */
    public function setDateAction($dateAction)
    {
        $this->dateAction = $dateAction;
    }
}
