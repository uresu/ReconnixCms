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
use Reconnix\CmsBundle\Form\Type\PageType;
use Symfony\Component\Form\Forms;
use Reconnix\CmsBundle\Entity\Content\Page;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Page Entity.
 * 
 * @ORM\Entity
 */
class Page extends ContentBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="tagline", length=128)
     */
    private $tagline;   

    /**
     * @var string
     *
     * @ORM\Column(name="subtagline", length=128)
     */
    private $subtagline;      

    /**
     * @var \Reconnix\CmsBundle\Entity\Content\Block
     *
     * @ORM\ManyToMany(targetEntity="Block")
     * @ORM\JoinTable(
     *      name="pages_blocks",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="block_id", referencedColumnName="id")}
     * )
     */
    private $blocks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set tagline
     *
     * @param string $tagline
     * @return Page
     */
    public function setTagline($tagline)
    {
        $this->tagline = htmlentities($tagline);

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
     * Set subtagline
     *
     * @param string $subtagline
     * @return Page
     */
    public function setSubtagline($subtagline)
    {
        $this->subtagline = htmlentities($subtagline);

        return $this;
    }

    /**
     * Get subtagline
     *
     * @return string 
     */
    public function getSubtagline()
    {
        return $this->subtagline;
    }

    /**
     * Add blocks
     *
     * @param \Reconnix\CmsBundle\Entity\Block $blocks
     * @return Page
     */
    public function addBlock(\Reconnix\CmsBundle\Entity\Content\Block $blocks)
    {
        $this->blocks[] = $blocks;

        return $this;
    }

    /**
     * Remove blocks
     *
     * @param \Reconnix\CmsBundle\Entity\Block $blocks
     */
    public function removeBlock(\Reconnix\CmsBundle\Entity\Content\Block $blocks)
    {
        $this->blocks->removeElement($blocks);
    }

    /**
     * Get blocks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * Return a list of blocks currently not used by the current Page object
     *
     * @param array $allBlocks
     * @return array
     */
    public function getUnusedBlocks(array $allBlocks = null){

        

        foreach ($this->getBlocks() as $usedBlock) {
            foreach($allBlocks as $key => $block){
                if($usedBlock->getName() == $block->getName()){
                    unset($allBlocks[$key]);
                }
            }
        }

        return $allBlocks;
    }


}
