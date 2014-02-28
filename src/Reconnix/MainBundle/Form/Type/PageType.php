<?php

namespace Reconnix\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('name', 'text');
        $builder->add('title', 'text');
        $builder->add('tagline', 'text');
        $builder->add('blocks', 'entity', array(
            'class' => 'ReconnixMainBundle:Block',
            'multiple' => true,
            'expanded' => true,
            'property' => 'name',
        ));
        $builder->add('save', 'submit');
	}

	public function getDefaultOptions(array $options){
		return array(
			'data_class' => 'Reconnix\MainBundle\Entity\Page'
		);
	}

	public function getName(){
		return 'page';
	}
}