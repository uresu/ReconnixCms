<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * AdminController
 */
class AdminController extends Controller
{
    /**
     * @return Response HTTP Repsonse 
     */    
    public function indexAction(){
    	
        return $this->render('ReconnixMainBundle:Admin:admin.index.html.twig');
    }
}