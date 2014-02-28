<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * PageController
 */
class PageController extends Controller
{

    /**
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction($name){
    	
        return $this->render('ReconnixMainBundle:Page:page.index.html.twig');
    }
}