<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Reconnix\CmsBundle\Entity\Menu\MenuItem;
use Reconnix\CmsBundle\Form\Type\MenuType;

use Reconnix\CmsBundle\Controller\Admin\CmsController;

/**
 * Renders all CRUD related pages from \admin\menu.
 */
class MenuController extends CmsController
{
    /**
     * Renders and displays the \admin\menu page.
     *
     * Processes Form input for configuration settings. 
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction(){

        $entities = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Menu\MenuItem')->findByCategory('front');
        $menu = $this->getEntityFields($entities, array('id', 'name'));

        return $this->render('ReconnixCmsBundle:Admin/Menu:admin.menu.index.html.twig', 
            array('menu' => $menu)
        );
    }

    /**
     * Renders and displays the \admin\menu\add page.
     *
     * Processes Form input for adding a new MenuItem.
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */ 
    public function addAction(){
        // create an empty object to store the submitted data
        $item = new MenuItem();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new MenuType(), $item);
 
        // check for a submitted form
        // pass default anydefault values for blank and optional fields
        if($this->submitFormOk($form, $item, array('category' => 'front', 'weight' => 0))){
            // succesfull update, return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_menu_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixCmsBundle:Admin/Menu:admin.menu.form.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Renders and displays the \admin\menu\edit\{id} page.
     *
     * Displays a prepopulated Form for the relevant MenuItem.
     * Processes Form input for editing a MenuItem.
     * 
     * @param integer $id The MenuItem id to be edited.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */  
    public function editAction($id){
        // fetch the Menu Item object
        $item = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Menu\MenuItem')->find($id);
        // create a pre-populated form
        $form = $this->createForm(new MenuType(), $item);

        // check for a submitted form
        // pass default anydefault values for blank and optional fields
        if($this->submitFormOk($form, $item, array('category' => 'front', 'weight' => 0))){
            // succesfull update, return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_menu_index'));
        }

        
        // no submission detected, or invalid submission, display the pre-populated
    	return $this->render('ReconnixCmsBundle:Admin/Menu:admin.menu.form.html.twig',
    		array(
                'id' => $id,
                'form' => $form->createView()
            )
    	);
    }

    /**
     * Delete a MenuItem from the database.
     *
     * @param integer $id The ID of the MenuItem to delete.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Redirect.
     */ 
    public function deleteAction($id){
        // load the entity for deleting
        $menuItem = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Menu\MenuItem')->find($id);
        // create entity manager and run the delete command
        $em = $this->getDoctrine()->getManager();
        $em->remove($menuItem);
        $em->flush();       

        return $this->redirect($this->generateUrl('reconnix_main_admin_menu_index'));
    } 


}
