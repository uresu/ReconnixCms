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
use Reconnix\CmsBundle\Entity\Configuration\Configuration;
use Reconnix\CmsBundle\Form\Type\ConfigurationType;

/**
 * Renders the \admin\configuration page.
 */
class ConfigurationController extends Controller
{
    /**
     * Renders and displays the \admin\configuration page.
     *
     * Processes Form input for configuration settings. 
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction(){
        // return the only DB row for configuration
        // if one doesn't yet exist, return an empty Configuration Entity
        $config = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Configuration\Configuration')->findOneByName('main');
        if(!is_object($config)){
            $config = new Configuration;
        }

        // build the form, pass the empty or prepopulated object to store the user input
        $form = $this->createForm(new ConfigurationType(), $config);
        
        // check for a submitted form
        // pass default anydefault values for blank and optional fields
        if($this->submitFormOk($form, $config, array('name' => 'main', 'lastUpdated' => new \DateTime))){
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
     * Check for Form submission and process if detected.
     *
     * Validation on the populated Entity is performed here, prior to persistence.
     *
     * @param \Symfony\Component\Form\Form $form The current Form object.
     * @param \Reconnix\CmsBundle\Entity\Configuration\Configuration $config The current Configuration object.
     *
     * @return Boolean true for successful submission, false for unsuccessful/no submission.
     */
    private function submitFormOk(Form $form, Configuration $config){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
            if($config->getLogoFile() === null){
                return false;
            }

            // set default name
            if($config->getName() === null){
                $config->setName('main');
            }

        	// manually update the date field to trigger PreUpdate()
        	// this is required because when only the file has been updated, PreUpdate() is not invoked
        	$config->setLastUpdated(new \DateTime);
            
            // persist
            $em = $this->getDoctrine()->getManager();
            $em->persist($config);
            $em->flush(); 
            return true;
        }         

        // no submission detected yet, or invalid submission
        return false;
    }
}
