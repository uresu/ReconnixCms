<?php

namespace Reconnix\ContentWizardBundle\Classes\Twig;

use Twig_LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StringToTwigParser {

	protected $container;

	public function __construct(ContainerInterface $container){
		$this->container = $container;
	}

    public function getSource($name)
    {
        // get from database
        return "MY TEST TEMPLATE $name";
    }

    public function isFresh($name, $time)
    {
        // determine from database
        return true;
    }

    public function getCacheKey($name)
    {
        // check if exists
        return 'db:' . $name;
    }

    public function stringToTwig($string){
    	return $this->container->get('twig')->render($string);
    }

}