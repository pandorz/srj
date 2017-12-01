<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilisateurLog
 * @ORM\Table(name="demande_newsletter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeNewsletterRepository")
 */
class DemandeNewsletter
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_creation", type="datetime", nullable=true)
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
     * @return int
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param int $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
}
