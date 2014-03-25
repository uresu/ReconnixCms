<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Entity\Configuration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Configuration Entity.
 *
 * @ORM\Entity
 * @ORM\HasLifeCycleCallbacks
 * @ORM\Table(name="configuration")
 * 
 */
class Configuration
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", length=32)
     */
    private $name;

    /**
     * Logo image path
     *
     * @var string
     *
     * @ORM\Column(type="text", length=255, nullable=false)
     */
    protected $logoPath;

    /**
     * Logo image
     *
     * @var \Symfony\Component\Validator\Constraints\File
     *
     * @Assert\File(
     *      maxSize = "10M",
     *      mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff", "image/svg+xml", "image/png"},
     *      maxSizeMessage = "The maximum allowed file size is 10MB.",
     *      mimeTypesMessage = "Invalid file extension."
     * )
     */
    protected $logoFile;

    /**
     * @ORM\Column(name="lastUpdated", type="datetime")
     */
    private $lastUpdated;

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
     * Set logo
     *
     * @param string $logo
     * @return Configuration
     */
    public function setLogoFile($logo)
    {
        $this->logoFile = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * Set logoPath
     *
     * @param string $logoPath
     * @return Configuration
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string 
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Called before saving the Entity
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){ 
        if($this->logoFile !== null){
            $filename = sha1(uniqid(mt_rand(), true));
            //$this->logoPath = $filename . '.' . $this->logoFile->guessExtension();
            $this->logoPath = $this->logoFile->getClientOriginalName();
        }
    }

    /**
     * Called before the removal of an Entity
     * 
     * @ORM\PostRemove
     */
    public function removeUpload(){
        if($file = $this->getAbsolutePath()){
            unlink($file);
        }
    }

    /**
     * Called after Entity persistance
     *
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function upload(){

        $this->logoFile->move($this->getUploadRootDir(), $this->logoPath);
        $this->logoFile = null;
    }

    /**
     * @return string|null
     */
    public function getAbsolutePath()
    {
        return null === $this->logoPath
            ? null
            : $this->getUploadRootDir().'/'.$this->logoPath;
    }

    /**
     * @return string|null
     */
    public function getWebPath()
    {
        return null === $this->logoPath
            ? null
            : $this->getUploadDir().'/'.$this->logoPath;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../../web/files/';
    }

    /**
     * Set lastUpdated
     *
     * @param \DateTime $lastUpdated
     * @return Configuration
     */
    public function setLastUpdated(\DateTime $lastUpdated = null)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Get lastUpdated
     *
     * @return \DateTime 
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Configuration
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
