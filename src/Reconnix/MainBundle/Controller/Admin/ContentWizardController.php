<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Reconnix\MainBundle\Entity\Content\Block;
use Reconnix\MainBundle\Entity\Content\ContentBase;
use Reconnix\MainBundle\Entity\Content\Page;
use Reconnix\MainBundle\Form\Type\BlockType;

use Reconnix\MainBundle\Classes\ContentCreator;

/**
 * ContentWizardController
 */
class ContentWizardController extends Controller{
    /**
     * Display list of existing Blocks 
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(Request $request){
    	// create a content object whose type is based on input
    	$contentCreator = new ContentCreator($this->get('form.factory'));
    	$contentCreator->setType('post');
    	// fetch the form object to work with and process
        //$page = new Page();
    	list($form, $content) = $contentCreator->createForm();
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            //$em = $this->getDoctrine()->getManager();
            $em = $this->getDoctrine()->getManager();
            $em->persist($content);
            $em->flush(); 
            return $this->redirect($this->generateUrl('reconnix_main_admin_content_wizard_index'));
        }   


        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixMainBundle:Admin/ContentWizard:admin.content_wizard.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );

    }
}