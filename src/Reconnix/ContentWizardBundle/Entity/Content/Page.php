<?php

namespace Reconnix\ContentWizardBundle\Entity\Content;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

use Reconnix\ContentWizardBundle\Entity\Content\Content;
use Reconnix\ContentWizardBundle\Classes\CreatorInterface;

/**
 * Represent a Page piece of Content
 * @ORM\Entity
 */
class Page extends Content
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
     * @ORM\ManyToMany(targetEntity="Content")
     * @ORM\JoinTable(
     *      name="content_wizard_pages_blocks",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="block_id", referencedColumnName="id")}
     * )
     */
    private $blocks;

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
     * @param \Reconnix\ContentWizardBundle\Entity\Block $blocks
     * @return Page
     */
    public function addBlock(\Reconnix\ContentWizardBundle\Entity\Content\Block $blocks)
    {
        $this->blocks[] = $blocks;

        return $this;
    }

    /**
     * Remove blocks
     *
     * @param \Reconnix\ContentWizardBundle\Entity\Block $blocks
     */
    public function removeBlock(\Reconnix\ContentWizardBundle\Entity\Content\Block $blocks)
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
     * Constructor
     */
    public function __construct()
    {
        $this->blocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
