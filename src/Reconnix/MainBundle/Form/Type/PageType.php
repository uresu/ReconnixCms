<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Configuration to render the Add Page form
 */
class PageType extends AbstractType{
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('name', 'text');
        $builder->add('title', 'text');
        $builder->add('tagline', 'text');
        $builder->add('content', 'textarea', array('attr' => array('cols' => '100', 'rows' => '5')));
        $builder->add('blocks', 'entity', array(
            'class' => 'ReconnixMainBundle:Content\Block',
            'multiple' => true,
            'expanded' => true,
            'property' => 'name',
        ));
        $builder->add('save', 'submit');
	}

	/**
     * @param array $options
     *
     * @return array  
     */
	public function getDefaultOptions(array $options){
		return array(
			'data_class' => 'Reconnix\MainBundle\Entity\Content\Page'
		);
	}

    /**
     * @return string 
     */
	public function getName(){
		return 'page';
	}
}