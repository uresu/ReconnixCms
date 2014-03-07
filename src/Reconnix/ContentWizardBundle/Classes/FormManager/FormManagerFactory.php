<?php

namespace Reconnix\ContentWizardBundle\Classes\FormManager;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormManagerFactory{

	protected $container;

	public function __construct(ContainerInterface $container){
		$this->container = $container;
	}

	public function getFormManager($type){
		switch($type){
			case 'page':
				return $this->container->get('page_form_manager');
			case 'post':
				return $this->container->get('post_form_manager');
			case 'block':
				return $this->container->get('block_form_manager');
		}
	}
}