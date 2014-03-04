<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Reconnix\MainBundle\Entity\Content\Block;
use Reconnix\MainBundle\Entity\Content\ContentBase;
use Reconnix\MainBundle\Entity\Content\Page;
use Reconnix\MainBundle\Form\Type\BlockType;

/**
 * ContentWizardController
 */
class ContentWizardController extends Controller{
    /**
     * Display list of existing Blocks 
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
    	// create a content object whose type is based on input
    	$content = new ContentBase();
    	$content->setType('page');
    	// fetch the form object to work with and process
    	$form = $content->createForm();
    

    	return new Response('done');
    }
}