<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Reconnix\CmsBundle\Entity\Content\ContentBase;

/**
 * Post Entity.
 *
 * @ORM\Entity
 */
class Post extends ContentBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="tag", length=32)
     */
    private $tag; 

    /**
     * @var string
     *
     * @ORM\Column(name="author", length=32)
     */
    private $author;    

    protected function create(){
        // return the post form object
    }    

    /**
     * Set tag
     *
     * @param string $tag
     * @return Post
     */
    public function setTag($tag)
    {
        $this->tag = htmlentities($tag);

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
        $this->author = htmlentities($author);

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
