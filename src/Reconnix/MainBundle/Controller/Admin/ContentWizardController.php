<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

//use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Reconnix\ContentWizardBundle\Classes\FormManager\FormManagerFactory;
use Reconnix\ContentWizardBundle\Classes\ContentBuilder\ContentBuilderFactory;

/**
 * ContentWizardController
 */
class ContentWizardController extends Controller{
    /**
     * Display list of existing Blocks 
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('type', 'choice', array(
                'choices' => array(
                    'page' => 'Page',
                    'post' => 'Post',
                    'block' => 'Block',
                ),
                'required' => true,
            ))
            ->add('begin', 'submit')
            ->getForm();

        $form->handleRequest($request);


        if($form->isValid()){
            return $this->redirect($this->generateUrl('reconnix_main_admin_content_wizard_add',
                array(
                    'type' => $form['type']->getData()
                )
            ));
        }

        return $this->render('ReconnixMainBundle:Admin/ContentWizard:admin.content_wizard.index.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function addAction(Request $request, $type){


        $page = $this->getDoctrine()->getRepository('ReconnixContentWizardBundle:Content\Page')->find(8);
        $blocks = $page->getBlocks();
        print '<pre>';
        foreach($blocks as $block){
            print_r($block);
        }
        $formManagerFactory = $this->container->get('form_manager_factory');
        $contentBuilderFactory = $this->container->get('content_factory');

        $formManager = $formManagerFactory->getFormManager($type);
        $content = $contentBuilderFactory->getContent($type);

        $form = $formManager->build($content);



        $form->handleRequest($request);
        if($form->isValid()){
            $formManager->submit($content);
        }

        return $this->render('ReconnixMainBundle:Admin/ContentWizard:admin.content_wizard.add.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
}