<?php

namespace Reconnix\MainBundle\Classes;

use Reconnix\MainBundle\Classes\ContentCreator;
use Symfony\Component\Form\FormFactoryInterface;
use Reconnix\MainBundle\Form\Type\PostType;
use Reconnix\MainBundle\Entity\Content\Post;

class PostCreator extends ContentCreator{


	public function __construct(FormFactoryInterface $formFactory){
        $this->formFactory = $formFactory;
    }

    protected function create(){
        // return the page form object
        $post = new Post();
        return array(
        	$this->formFactory->create(new PostType(), $post),
        	$post
        );
    }
}