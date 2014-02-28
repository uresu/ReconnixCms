<?php

namespace Reconnix\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BlockType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name', 'text');
        $builder->add('content', 'textarea', array('attr' => array('cols' => '100', 'rows' => '5')));
        $builder->add('save', 'submit');
	}

	public function getDefaultOptions(array $options){
		return array(
			'data_class' => 'Reconnix\MainBundle\Entity\Content\Block'
		);
	}

	public function getName(){
		return 'block';
	}
}