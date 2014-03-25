<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Reconnix\CmsBundle\Entity\Content\Page;
use Reconnix\CmsBundle\Entity\Content\Post;
use Symfony\Component\Form\FormFactoryInterface;

/** 
 * ContentBase Entity.
 *
 * @ORM\Entity 
 * @ORM\Table(name="content")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="contentType", type="string")
 * @ORM\DiscriminatorMap({"post" = "Post", "page" = "Page", "template" = "Template"}) 
 */
class ContentBase{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="name", length=32)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", length=64)
     */
    private $title; 

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

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
     * Set name
     *
     * @param string $name
     * @return ContentBase
     */
    public function setName($name)
    {
        $this->name = htmlentities($name);

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

    /**
     * Set title
     *
     * @param string $title
     * @return ContentBase
     */
    public function setTitle($title)
    {
        $this->title = htmlentities($title);

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ContentBase
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ContentBase
     */
    public function setDate(\DateTime $date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /** 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setDateValue(){
        $this->date = new \DateTime();
    }
}
