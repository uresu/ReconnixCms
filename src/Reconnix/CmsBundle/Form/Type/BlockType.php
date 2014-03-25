<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Configuration to render the Add Block form.
 */
class BlockType extends AbstractType{

    /**
     * Regions available as options.
     *
     * @var array
     */
    private $regions = array();

    /**
     * Backgrounds available as options.
     *
     * @var array
     */
    private $backgrounds = array();    

    /**
     * Constructor.
     *
     * Set default values for checkboxes and radio selections.
     */
    public function __construct(){
        $this->setDefaultRegions();
        $this->setDefaultBackgrounds();
    }

	/**
     * Build the Form by defining each input field.
     *
	 * @param FormBuilderInterface $builder
	 * @param array $options 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name', 'text');
        $builder->add('content', 'textarea', array('attr' => array('class' => 'tinymce', 'data-theme' => 'advanced')));
        $builder->add('region', 'choice', array('choices' => $this->getRegions()));
        $builder->add('background', 'choice', array('choices' => $this->getBackgrounds()));
        $builder->add('classList', 'text', array("required" => false));
        $builder->add('save', 'submit');
	}

    /**
     * Returns the name of this type.
     *
     * @return string 
     */
	public function getName(){
		return 'block';
	}

    /**
     * Set the region choices.
     *
     * @param array $params An array of region field options: "value" => "label"
     */
    public function setRegions(array $params){
        $this->regions = $params;
    }

    /**
     * Get the region choices.
     *
     * @return array $regions As array region field options: "value" => "label"
     */
    public function getRegions(){
        return $this->regions;
    }

    /**
     * Set the background choices.
     *
     * @param array $params An array of region field options: "value" => "label"
     */
    public function setBackgrounds(array $params){
        $this->backgrounds = $params;
    }

    /**
     * Get the background choices.
     *
     * @return array $regions As array region field options: "value" => "label"
     */
    public function getBackgrounds(){
        return $this->regions;
    }

    /**
     * Set the default region options on Form construction.
     */
    private function setDefaultRegions(){
        $this->regions = array(
            'header' => 'Header',
            'top' => 'Top', 
            'middle' => 'Middle', 
            'bottom' => 'Bottom',
            'footer' => 'Footer',           
        );
    }

    /**
     * Set the default background options on Form construction.
     */
    private function setDefaultBackgrounds(){
        $this->regions = array(
            'white' => 'White',
            'light-grey' => 'Light Grey',
            'dark-grey' => 'Dark Grey',         
        );
    }
}
