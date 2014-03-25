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
 * Configuration to render the Add Menu form.
 */
class MenuType extends AbstractType{

	/**
     * Build the Form by defining each input field.
     *
	 * @param FormBuilderInterface $builder
	 * @param array $options 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('url', 'text');
        $builder->add('name', 'text');
        $builder->add('weight', 'text');
        //$builder->add('content', 'textarea', array('attr' => array('rows' => '35', 'class' => 'tinymce', 'data-theme' => 'advanced')));
        $builder->add('save', 'submit');
	}

    /**
     * Returns the name of this type.
     *
     * @return string 
     */
	public function getName(){
		return 'menu';
	}
}
