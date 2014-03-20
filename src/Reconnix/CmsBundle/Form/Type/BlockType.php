<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Configuration to render the Add Block form
 */
class BlockType extends AbstractType{

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name', 'text');
        //$builder->add('content', 'textarea', array('attr' => array('rows' => '35', 'cols' => '150')));
        $builder->add('content', 'textarea', array('attr' => array('class' => 'tinymce', 'data-theme' => 'advanced')));
        $builder->add('region', 'choice', array(
        	'choices' => array(
        		'header' => 'Header',
        		'top' => 'Top', 
        		'middle' => 'Middle', 
        		'bottom' => 'Bottom',
        		'footer' => 'Footer',
        	)
        ));
        
        $builder->add('background', 'choice', array(
            'choices' => array(
                'white' => 'White',
                'light-grey' => 'Light Grey',
                'dark-grey' => 'Dark Grey',
            )
        ));

        $builder->add('classList', 'text');
        //$builder->add('content', 'textarea', array('attr' => array('rows' => '35', 'class' => 'tinymce', 'data-theme' => 'advanced')));
        $builder->add('save', 'submit');
	}

	/**
     * @param array $options
     *
     * @return array  
     */
	public function getDefaultOptions(array $options){
		return array(
			'data_class' => 'Reconnix\CmsBundle\Entity\Content\Block'
		);
	}

    /**
     * @return string 
     */
	public function getName(){
		return 'block';
	}
}
