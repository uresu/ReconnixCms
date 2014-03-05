<?php

namespace Reconnix\MainBundle\Classes;

use Reconnix\MainBundle\Classes\ContentCreator;
use Symfony\Component\Form\FormFactoryInterface;
use Reconnix\MainBundle\Form\Type\PageType;
use Reconnix\MainBundle\Entity\Content\Page;

class PageCreator extends ContentCreator{


	public function __construct(FormFactoryInterface $formFactory){
        $this->formFactory = $formFactory;
    }

    protected function create(){
        // return the page form object
        $page = new Page();
        return array(
        	$this->formFactory->create(new PageType(), $page),
        	$page
        );
    }
}