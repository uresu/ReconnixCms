<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Reconnix\CmsBundle\Entity\Content\Template;
use Reconnix\CmsBundle\Form\Type\TemplateType;

use Reconnix\CmsBundle\Controller\Admin\CmsController;

/**
 * Renders all CRUD related pages from \admin\templates.
 */
class TemplatesController extends CmsController
{
    
    /**
     * Renders and displays the \admin\templates page.
     *
     * Displays all existing Templates. 
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction(){
        
        $entities = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Template')->findAll();
        $templates = $this->getEntityFields($entities, array('id', 'title'));

        return $this->render('ReconnixCmsBundle:Admin/Templates:admin.templates.index.html.twig', 
            array('templates' => $templates)
        );
    }

    /**
     * Renders and displays the \admin\templates\add page.
     *
     * Processes Form input for adding a new Template.
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */    
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $template = new Template();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new TemplateType(), $template);
        
        // check for a submitted form
        if(self::submitFormOk($form, $template)){
            // succesfull update, return to post index
            return $this->redirect($this->generateUrl('reconnix_main_admin_templates_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixCmsBundle:Admin/Templates:admin.templates.form.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Renders and displays the \admin\templates\edit\{id} page.
     *
     * Displays a prepopulated Form for the relevant Template.
     * Processes Form input for editing a Template.
     * 
     * @param integer $id The Template id to be edited.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */ 
    public function editAction($id){
        // fetch the Post object
        $template = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Template')->find($id);
        // create a pre-populated form
        $form = $this->createForm(new TemplateType(), $template);

        // check for a submitted form
        if(self::submitFormOk($form, $template)){
            // succesfull update, return to post index
            return $this->redirect($this->generateUrl('reconnix_main_admin_templates_index'));
        }

        // no submission detected, or invalid submission, display the pre-populated
        return $this->render('ReconnixCmsBundle:Admin/Templates:admin.templates.form.html.twig',
            array(
                'id' => $id,
                'form' => $form->createView()
            )
        );
    }

    /**
     * Delete a Template from the database.
     *
     * @param integer $id The ID of the Template to delete.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Redirect.
     */ 
    public function deleteAction($id){
        // load the entity for deleting
        $template = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Template')->find($id);
        
        // persist
        $em = $this->getDoctrine()->getManager();
        $em->remove($template);
        $em->flush();       

        return $this->redirect($this->generateUrl('reconnix_main_admin_templates_index'));
    } 
}
