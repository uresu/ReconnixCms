<?php

namespace Reconnix\MainBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Reconnix\MainBundle\Entity\Content\ContentBase;
use Reconnix\MainBundle\Form\Type\PageType;
use Symfony\Component\Form\Forms;
use Reconnix\MainBundle\Entity\Content\Page;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Represent a Page piece of Content
 * @ORM\Entity
 */
class Page extends ContentBase
{
    /**
     * @ORM\Column(name="tagline", length=128)
     */
    private $tagline;   

    /**
     * @ORM\Column(name="subtagline", length=128)
     */
    private $subtagline;      

    /**
     * @ORM\ManyToMany(targetEntity="Block")
     * @ORM\JoinTable(
     *      name="pages_blocks",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="block_id", referencedColumnName="id")}
     * )
     */
    private $blocks;

    public function __construct(){
        $this->blocks = new ArrayCollection();
    }

    protected function create(){
        //print '<pre>';
        //print_r($this);
        $formFactory = Forms::createFormFactory();
        
    }



    /**
     * Set tagline
     *
     * @param string $tagline
     * @return Page
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
     * Set sub_tagline
     *
     * @param string $subtagline
     * @return Page
     */
    public function setSubtagline($subTagline)
    {
        $this->subtagline = $subTagline;

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
     * @param \Reconnix\MainBundle\Entity\Block $blocks
     * @return Page
     */
    public function addBlock(\Reconnix\MainBundle\Entity\Content\Block $blocks)
    {
        $this->blocks[] = $blocks;

        return $this;
    }

    /**
     * Remove blocks
     *
     * @param \Reconnix\MainBundle\Entity\Block $blocks
     */
    public function removeBlock(\Reconnix\MainBundle\Entity\Content\Block $blocks)
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
}
