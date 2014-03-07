<?php

namespace Reconnix\MainBundle\Classes;

use Symfony\Component\Form\FormFactoryInterface;

class ContentCreator{

	protected $formFactory;
	private $contentCreator;

    public function setContentType($contentType){
        $this->contentCreator = $contentType;
    }

    public function createForm(){
        // return the relevant form object
	    return $this->contentCreator->create();
    }
}