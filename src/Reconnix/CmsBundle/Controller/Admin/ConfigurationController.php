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

use Reconnix\CmsBundle\Entity\Configuration\Configuration;
use Reconnix\CmsBundle\Form\Type\ConfigurationType;

/**
 * MenuController
 */
class ConfigurationController extends Controller
{

    /**
     * Display list of existing Menu items 
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
        // create an empty object to store the submitted data
        
        $config = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Configuration\Configuration')->find(1);
        //$config = new Configuration();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new ConfigurationType(), $config);
        
        // check for a submitted form
        if(self::submitFormOk($form, $config)){
            // succesfull update, return to post index
            return $this->redirect($this->generateUrl('reconnix_main_admin_configuration_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixCmsBundle:Admin/Configuration:admin.configuration.index.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param Form $form
     * @param Configuration $config
     *
     * @return Boolean true for success
     */
    private function submitFormOk(Form $form, Configuration $config){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
        	// manually update the date field to trigger PreUpdate()
        	// this is required because when only the file has been updated, PreUpdate() is not invoked
        	$config->setLastUpdated(new \DateTime);
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($config);
            $em->flush(); 
            return true;
        }         

        // no submission detected yet, or invalid submission
        return false;
    }
}
