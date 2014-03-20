<?php

/*
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

/**
 * MenuController
 */
class MenuController extends Controller
{

    /**
     * Display list of existing Menu items 
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
        // fetch all Menu items
        $menuObjs = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Menu\MenuItem')->findByCategory('front');
        // disect out the id and name of each Block object for passing to the view
        $menu = array();
        foreach($menuObjs as $menuObj){
            $menu[] = array(
                'id' => $menuObj->getId(),
                'name' => $menuObj->getName()
            );
        }

        return $this->render('ReconnixCmsBundle:Admin/Menu:admin.menu.index.html.twig', 
            array('menu' => $menu)
        );
    }

    /**
     * @return Reponse HTTP Repsonse 
     */ 
    public function addAction(){
        // create an empty object to store the submitted data
        $item = new MenuItem();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new MenuType(), $item);
 
        // check for a submitted form
        if(self::submitFormOk($form, $item)){
            // succesfull update, return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_menu_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixCmsBundle:Admin/Menu:admin.menu.add.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param integer $id The Menu Item id
     * 
     * @return Reponse HTTP Repsonse 
     */ 
    public function editAction($id){
        // fetch the Menu Item object
        $item = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Menu\MenuItem')->find($id);
        //$block->setContent(html_entity_decode($block->getContent()));
        // create a pre-populated form
        $form = $this->createForm(new MenuType(), $item);

        // check for a submitted form
        if(self::submitFormOk($form, $item)){
            // succesfull update, return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_menu_index'));
        }

        
        // no submission detected, or invalid submission, display the pre-populated
    	return $this->render('ReconnixCmsBundle:Admin/Menu:admin.menu.edit.html.twig',
    		array(
                'id' => $id,
                'form' => $form->createView()
            )
    	);
    }

    /**
     * @param Form $form
     * @param Block $block
     *
     * @return Boolean true for success
     */
    private function submitFormOk(Form $form, MenuItem $item){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
            // set default value for Category
            if($item->getCategory() === NULL){
                $item->setCategory('front');
            }

            // set default value for Weight
            if($item->getWeight() === NULL){
                $item->setWeight(0);
            }
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush(); 

            return true;
        }         

        // no submission detected yet, or invalid submission
        return false;
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Reponse HTTP Repsonse 
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
