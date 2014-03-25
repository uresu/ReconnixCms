<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Renders the \admin page.
 */
class AdminController extends Controller
{
    /**
     * Renders and displays the \admin page.
     *
     * Displays the Admin Home page with all Admin menu items.
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response 
     */    
    public function indexAction(){

        $menuItems = $this->getDoctrine()->getManager()->getRepository('ReconnixCmsBundle:Menu\MenuItem')->getAdminMenuItems();

        return $this->render('ReconnixCmsBundle:Admin:admin.index.html.twig', array(
        	'menu' => $menuItems
        ));
    }
}
