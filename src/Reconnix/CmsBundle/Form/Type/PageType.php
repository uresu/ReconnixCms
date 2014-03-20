<?php

/*
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

    public function __construct(Page $page){
        $this->page = $page;
    }
	
	/**
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
        //$builder->add('content', 'textarea', array('attr' => array('rows' => '35', 'cols' => '150'), 'required' => false));
        //$builder->add('content', 'textarea', array('attr' => array('rows' => '35', 'class' => 'tinymce', 'data-theme' => 'advanced')));
        /**/
        $builder->add('save', 'submit');
	}

	/**
     * @param array $options
     *
     * @return array  
     */
	public function getDefaultOptions(array $options){
		return array(
			'data_class' => 'Reconnix\CmsBundle\Entity\Content\Page'
		);
	}

    /**
     * @return string 
     */
	public function getName(){
		return 'page';
	}
}
