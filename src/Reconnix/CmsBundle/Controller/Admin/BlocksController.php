<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller\Admin;

use Reconnix\CmsBundle\Controller\Admin\CmsController;
use Reconnix\CmsBundle\Entity\Content\Block;
use Reconnix\CmsBundle\Form\Type\BlockType;

/**
 * Renders all CRUD related pages from \admin\blocks.
 */
class BlocksController extends CmsController
{
    /**
     * Renders and displays the \admin\blocks page.
     *
     * Displays all existing Blocks. 
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction(){

        $entites = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Block')->findAll();
        $blocks = $this->getEntityFields($entites, array('id', 'name'));

        return $this->render('ReconnixCmsBundle:Admin/Blocks:admin.blocks.index.html.twig', 
            array('blocks' => $blocks)
        );
    }

    /**
     * Renders and displays the \admin\blocks\add page.
     *
     * Processes Form input for adding a new Block.
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */ 
    public function addAction(){
        // create an empty object to store the submitted data
        $block = new Block();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new BlockType(), $block);

        // check for a submitted form
        if($this->submitFormOk($form, $block)){
            // succesfull update, return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixCmsBundle:Admin/Blocks:admin.blocks.add.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Renders and displays the \admin\blocks\edit\{id} page.
     *
     * Displays a prepopulated Form for the relevant Block.
     * Processes Form input for editing a Block.
     * 
     * @param integer $id The Block id to be edited.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */ 
    public function editAction($id){
        // fetch the Block object
        $block = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Block')->find($id);
        // build the form, pass the prepopulated object to display
        $form = $this->createForm(new BlockType(), $block);

        // check for a submitted form
        if($this->submitFormOk($form, $block)){
            // succesfull update, return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
        }
        
        // no submission detected, or invalid submission, display the pre-populated
    	return $this->render('ReconnixCmsBundle:Admin/Blocks:admin.blocks.edit.html.twig',
    		array(
                'id' => $id,
                'name' => $block->getName(),
                'form' => $form->createView()
            )
    	);
    }

    /**
     * Delete a Block from the database.
     *
     * @param integer $id The ID of the Block to delete.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Redirect.
     */ 
    public function deleteAction($id){
        // load the entity for deleting
        $block = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Block')->find($id);
        
        // persist
        $em = $this->getDoctrine()->getManager();
        $em->remove($block);
        $em->flush();       

        return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
    } 
}
