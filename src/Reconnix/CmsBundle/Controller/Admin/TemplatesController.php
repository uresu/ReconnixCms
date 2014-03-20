<?php

/*
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

/**
 * PostsController
 */
class TemplatesController extends Controller
{
    
    /**
     * Display list of existing Posts
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
        
        // fetch all Posts
        $templateObjs = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Template')->findAll();
        // disect out the id and name of each Post object for passing to the view
        $templates = array();
        foreach($templateObjs as $templateObj){
            $templates[] = array(
                'id' => $templateObj->getId(),
                'title' => $templateObj->getTitle()
            );
        }

        return $this->render('ReconnixCmsBundle:Admin/Templates:admin.templates.index.html.twig', 
            array('templates' => $templates)
        );
    }

    /**
     * @param Request $request The HTTP Request
     * 
     * @return Reponse HTTP Repsonse 
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
        return $this->render('ReconnixCmsBundle:Admin/Templates:admin.templates.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Reponse HTTP Repsonse 
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
        return $this->render('ReconnixCmsBundle:Admin/Templates:admin.templates.edit.html.twig',
            array(
                'id' => $id,
                'form' => $form->createView()
            )
        );
    }

    /**
     * @param Form $form
     * @param Template $template
     *
     * @return Boolean true for success
     */
    private function submitFormOk(Form $form, Template $template){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
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
        $template = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Template')->find($id);
        // create entity manager and run the delete command
        $em = $this->getDoctrine()->getManager();
        $em->remove($template);
        $em->flush();       

        return $this->redirect($this->generateUrl('reconnix_main_admin_templates_index'));
    } 
}
