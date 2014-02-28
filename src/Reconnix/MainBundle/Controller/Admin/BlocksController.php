<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Content\Block;
use Reconnix\MainBundle\Form\Type\BlockType;

/**
 * BlocksController
 */
class BlocksController extends Controller
{

    /**
     * @return Repsonse HTTP Repsonse 
     */
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.index.html.twig');
    }

    /**
     * @param Request $request The HTTP Request
     * 
     * @return Repsonse HTTP Repsonse 
     */ 
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $block = new Block();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new BlockType(), $block);
        // handle form submission
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($block);
            $em->flush(); 
            // return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.add.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Repsonse HTTP Repsonse 
     */ 
    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.edit.html.twig',
    		array("id" => $id)
    	);
    }
}