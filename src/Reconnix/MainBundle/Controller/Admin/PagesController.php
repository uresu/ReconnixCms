<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Content\Page;
use Reconnix\MainBundle\Form\Type\PageType;

/**
 * PagesController
 */
class PagesController extends Controller
{

    /**
     * @return Repsonse HTTP Repsonse 
     */
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.index.html.twig');
    }

    /**
     * @param Request $request The HTTP Request
     * 
     * @return Repsonse HTTP Repsonse 
     */
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $page = new Page();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new PageType(), $page);
        // handle form submission
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();  
            // return to pages index
            return $this->redirect($this->generateUrl('reconnix_main_admin_pages_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Repsonse HTTP Repsonse 
     */ 
    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.edit.html.twig',
    		array("id" => $id)
    	);
    }
}