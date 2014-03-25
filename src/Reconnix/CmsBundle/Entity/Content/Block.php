<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;

/** 
 * Block Entity.
 *
 * @ORM\Table(name="block")
 * @ORM\Entity
 */
class Block
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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="region", length = 8)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="background", length = 16, nullable=true)
     */
    private $background;

    /**
     * @var string
     *
     * @ORM\Column(name="classList", type="text", nullable=true)
     */
    private $classList;

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
     * @return Block
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
     * Set content
     *
     * @param string $content
     * @return Block
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
     * Set region
     *
     * @param string $region
     * @return Block
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set background
     *
     * @param string $background
     * @return Block
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string 
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set classList
     *
     * @param string $classList
     * @return Block
     */
    public function setClassList($classList)
    {
        $this->classList = htmlentities($classList);

        return $this;
    }

    /**
     * Get classList
     *
     * @return string 
     */
    public function getClassList()
    {
        return $this->classList;
    }
}
