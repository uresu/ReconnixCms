<?php

namespace Reconnix\MainBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Reconnix\MainBundle\Entity\Content\ContentBase;

/**
 * Represents a Post piece of Content
 * @ORM\Entity
 */
class Post extends ContentBase
{
    /**
     * @ORM\Column(name="tagline", length=128)
     */
    private $tagline; 

     /**
     * @ORM\Column(name="author", length=32)
     */
    private $author;        

    /**
     * Set tagline
     *
     * @param string $tagline
     * @return Post
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * Get tagline
     *
     * @return string 
     */
    public function getTagline()
    {
        return $this->tagline;
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
