<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Reconnix\MenuManagerBundle\Classes\MenuManager\MenuManager;

/**
 * AdminController
 */
class AdminController extends Controller
{
    /**
     * @return Response HTTP Repsonse 
     */    
    public function indexAction(){

        // get the menu items
        $menuManager = $this->container->get('menu_manager');
        $menuItems = $menuManager->getAdminMenuItems('ReconnixMainBundle:Menu\MenuItem');

        return $this->render('ReconnixMainBundle:Admin:admin.index.html.twig', array(
        	'menu' => $menuItems
        ));
    }
}