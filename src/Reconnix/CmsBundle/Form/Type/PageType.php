<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Reconnix\CmsBundle\Entity\Content\Page;

/**
 * Configuration to render the Add Page form
 */
class PageType extends AbstractType{

    /**
     * Current Page object that this Form instance relates too.
     *
     * @var \Reconnix\CmsBundle\Entity\Content\Page
     */
    private $page;

    /**
     * Constructor.
     *
     * Set the current Page object so we can access its ID.
     *
     * @param Page $page Current Page object
     */
    public function __construct(Page $page){
        $this->page = $page;
    }
	
    /**
     * Build the Form by defining each input field.
     *
     * @param FormBuilderInterface $builder
     * @param array $options 
     */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('name', 'text');
        $builder->add('title', 'text');
        $builder->add('tagline', 'text');
        $builder->add('subtagline', 'text', array('required' => false ));

        if(!$this->page->getId()){
            $builder->add('blocks', 'entity', array(
                'class' => 'ReconnixCmsBundle:Content\Block',
                'multiple' => true,
                'expanded' => true,
                'property' => 'name',
            ));   
        }

        $builder->add('save', 'submit');
	}

    /**
     * Returns the name of this type.
     *
     * @return string 
     */
	public function getName(){
		return 'page';
	}
}
