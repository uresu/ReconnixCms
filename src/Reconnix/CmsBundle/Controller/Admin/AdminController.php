<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller\Admin;

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

        $em = $this->getDoctrine()->getManager();
        $menuItems = $em->getRepository('ReconnixCmsBundle:Menu\MenuItem')->getAdminMenuItems();

        return $this->render('ReconnixCmsBundle:Admin:admin.index.html.twig', array(
        	'menu' => $menuItems
        ));
    }
}
