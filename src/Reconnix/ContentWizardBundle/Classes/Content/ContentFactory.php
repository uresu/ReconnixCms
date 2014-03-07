<?php

namespace Reconnix\ContentWizardBundle\Classes\Content;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ContentFactory{

	protected $container;

	public function __construct(ContainerInterface $container){
		$this->container = $container;
	}

	public function getContent($type){
		switch($type){
			case 'page':
				return $this->container->get('page');
			case 'post':
				return $this->container->get('post');
			case 'block':
				return $this->container->get('block');
		}	
	}
}