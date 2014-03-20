<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Reconnix\MainBundle\Entity\Content\Block;
use Reconnix\MainBundle\Form\Type\BlockType;

/**
 * BlocksController
 */
class BlocksController extends Controller
{

    /**
     * Display list of existing Blocks 
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
        // fetch all Blocks
        $blockObjs = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Block')->findAll();
        // disect out the id and name of each Block object for passing to the view
        $blocks = array();
        foreach($blockObjs as $blockObj){
            $blocks[] = array(
                'id' => $blockObj->getId(),
                'name' => $blockObj->getName()
            );
        }

        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.index.html.twig', 
            array('blocks' => $blocks)
        );
    }

    /**
     * @return Reponse HTTP Repsonse 
     */ 
    public function addAction(){
        // create an empty object to store the submitted data
        $block = new Block();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new BlockType(), $block);
 
        // check for a submitted form
        if(self::submitFormOk($form, $block)){
            // succesfull update, return to block index
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
     * @return Reponse HTTP Repsonse 
     */ 
    public function editAction($id){
        // fetch the Block object
        $block = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Block')->find($id);
        $block->setContent(html_entity_decode($block->getContent()));
        // create a pre-populated form
        $form = $this->createForm(new BlockType(), $block);

        // check for a submitted form
        if(self::submitFormOk($form, $block)){
            // succesfull update, return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
        }

        
        // no submission detected, or invalid submission, display the pre-populated
    	return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.edit.html.twig',
    		array(
                'id' => $id,
                'name' => $block->getName(),
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
    private function submitFormOk(Form $form, Block $block){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
            // set default value for Category
            if($block->getBackground() === NULL){
                $block->setBackground('white');
            }

            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($block);
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
        $block = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Block')->find($id);
        // create entity manager and run the delete command
        $em = $this->getDoctrine()->getManager();
        $em->remove($block);
        $em->flush();       

        return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
    } 
}