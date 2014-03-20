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
 * Configuration to render the Add Block form
 */
class ConfigurationType extends AbstractType{

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options 
	 */
	public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('logoFile', 'file');
        $builder->add('save', 'submit');
	}

/*
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
    	$resolver->setDefaults(
        	array(
            	'data_class' => 'Reconnix\MainBundle\Entity\Configuration\Configuration',
       	)
    	);
	}
*/
	/**
     * @param array $options
     *
     * @return array  
     */
	public function getDefaultOptions(array $options){
		return array(
			'data_class' => 'Reconnix\MainBundle\Entity\Configuration\Configuration'
		);
	}

    /**
     * @return string 
     */
	public function getName(){
		return 'configuration';
	}
}