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
 * Configuration to render the Configuration form.
 */
class ConfigurationType extends AbstractType{

	/**
     * Build the Form by defining each input field.
     *
	 * @param FormBuilderInterface $builder
	 * @param array $options 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('logoFile', 'file', array("required" => false));
        $builder->add('save', 'submit');
	}

    /**
     * Returns the name of this type.
     *
     * @return string 
     */
	public function getName(){
		return 'configuration';
	}
}
