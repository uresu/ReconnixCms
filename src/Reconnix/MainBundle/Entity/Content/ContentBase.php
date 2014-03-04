<?php

namespace Reconnix\MainBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Reconnix\MainBundle\Entity\Content\Page;
use Reconnix\MainBundle\Entity\Content\Post;

/** 
 * ContentBase
 *
 * @ORM\Entity 
 * @ORM\Table(name="content")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="content_type", type="string")
 * @ORM\DiscriminatorMap({"post" = "Post", "page" = "Page"}) 
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(name="name", length=32)
     */
    private $name;

    /**
     * @ORM\Column(name="title", length=32)
     */
    private $title; 

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * 
     */
    protected $contentCreator;

    public function setType($contentType){
        switch($contentType){
            case 'page':
                $this->contentCreator = new Page();
                break;
            case 'post':
                $this->contentCreator = new Post();
                break;               
        }        
    }

    public function createForm(){
        //print_r($this->contentCreator);
        return $this->contentCreator->create();
    }

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

    /**
     * Set title
     *
     * @param string $title
     * @return ContentBase
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
