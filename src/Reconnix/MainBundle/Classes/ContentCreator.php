<?php

namespace Reconnix\MainBundle\Classes;

use Symfony\Component\Form\FormFactoryInterface;

class ContentCreator{

	protected $formFactory;
	private $contentCreator;

    public function __construct(FormFactoryInterface $formFactory){
        $this->formFactory = $formFactory;
    }

    public function setType($contentType){
        switch($contentType){
            case 'page':
                $this->contentCreator = new PageCreator($this->formFactory);
                break;
            case 'post':
                $this->contentCreator = new PostCreator($this->formFactory);
                break;               
        }        
    }

    public function createForm(){
        // return the relevant form object
	    return $this->contentCreator->create();
    }
}