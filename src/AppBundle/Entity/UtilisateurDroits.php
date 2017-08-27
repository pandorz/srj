<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * UtilisateurDroits
 *
 * @ORM\Table(name="utilisateur_droits", indexes={
 *     @ORM\Index(name="fk_id_utilisateur", columns={"fk_id_utilisateur"})
 * })
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class UtilisateurDroits extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var \AppBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_id_utilisateur", referencedColumnName="id")
     * })
     */
    private $fkUtilisateur;

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
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

   
    /**
     * Set fkUtilisateur
     *
     * @param Utilisateur $fkUtilisateur
     *
     * @return UtilisateurDroits
     */
    public function setFkUtilisateur(Utilisateur $fkUtilisateur = null)
    {
        $this->fkUtilisateur = $fkUtilisateur;

        return $this;
    }

    /**
     * Get fkUtilisateur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getFkUtilisateur()
    {
        return $this->fkUtilisateur;
    }

    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     *
     * @return UtilisateurDroits
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
     * @return UtilisateurDroits
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
}
