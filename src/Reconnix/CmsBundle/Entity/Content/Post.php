<?php

namespace Reconnix\CmsBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Reconnix\CmsBundle\Entity\Content\ContentBase;

/**
 * Represents a Post piece of Content
 * @ORM\Entity
 */
class Post extends ContentBase
{
    /**
     * @ORM\Column(name="tag", length=32)
     */
    private $tag; 

     /**
     * @ORM\Column(name="author", length=32)
     */
    private $author;    

    protected function create(){
        // return the post form object
    }    

    /**
     * Set tag
     *
     * @param string $tagline
     * @return Post
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
