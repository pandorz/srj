<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
    private $id;

    /**
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
    
    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     *  Used to upload file
     *
     * @var \DateTime
     */
    private $updated;
    
    const PATH_TO_UPLOAD = 'Images';
    const EXT_AUTORISEES = ['jpg', 'jpeg', 'png'];

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
     /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        $fs = new Filesystem();

        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        //TODO LTS : sanitise file name
        $path_media = $this->getAbsolutePath(true);

        if (!$fs->exists($path_media)) {
            $fs->mkdir($path_media);
        }

        $this->getFile()->move(
            $path_media,
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->url = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Lifecycle callback to upload the file to the server
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }
    
    public function getAbsolutePath()
    {
        return $this->getUploadRootDir().DIRECTORY_SEPARATOR.$this->url;
    }

    public function getWebPath()
    {
        return $this->getUploadDir().DIRECTORY_SEPARATOR.$this->url;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.DIRECTORY_SEPARATOR.
            '..'.DIRECTORY_SEPARATOR.
            '..'.DIRECTORY_SEPARATOR.
            '..'.DIRECTORY_SEPARATOR.
            'web'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return DIRECTORY_SEPARATOR.self::PATH_UPLOAD;
    }
    
    public function __toString()
    {
        return (is_null($this->getUrl()) ? '' : $this->getUrl());
    }
}
