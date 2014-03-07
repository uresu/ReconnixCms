<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\ContentWizardBundle\Form\Type;

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
        $builder->add('subtagline', 'text');
        $builder->add('content', 'textarea', array('attr' => array('rows' => '35', 'cols' => '150')));
        //$builder->add('content', 'textarea', array('attr' => array('rows' => '35', 'class' => 'tinymce', 'data-theme' => 'advanced')));
        $builder->add('blocks', 'entity', array(
            'class' => 'ReconnixContentWizardBundle:Content\Block',
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
			'data_class' => 'Reconnix\ContentWizardBundle\Entity\Content\Page'
		);
	}

    /**
     * @return string 
     */
	public function getName(){
		return 'page';
	}
}