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
use Reconnix\MainBundle\Entity\Content\Page;
use Reconnix\MainBundle\Form\Type\PageType;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * PagesController
 */
class PagesController extends Controller
{

    /**
     * Display list of existing Pages
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
        // fetch all Pages
        $pageObjs = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findAll();
        // disect out the id and name of each Page object for passing to the view
        $pages = array();
        foreach($pageObjs as $pageObj){
            $pages[] = array(
                'id' => $pageObj->getId(),
                'title' => $pageObj->getTitle()
            );
        }

        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.index.html.twig', 
            array('pages' => $pages)
        );
    }

    /**
     * @param Request $request The HTTP Request
     * 
     * @return Reponse HTTP Repsonse 
     */
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $page = new Page();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new PageType(), $page);
        
        // check for a submitted form
        if(self::submitFormOk($form, $page)){
            // succesfull update, return to page index
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
     * @return Reponse HTTP Repsonse 
     */ 
    public function editAction($id){
        // fetch the Page object
        $page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->find($id);
        // create a pre-populated form
        $form = $this->createForm(new PageType(), $page);

        // check for a submitted form
        if(self::submitFormOk($form, $page)){
            // succesfull update, return to page index
            return $this->redirect($this->generateUrl('reconnix_main_admin_pages_index'));
        }

        // no submission detected, or invalid submission, display the pre-populated
        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.edit.html.twig',
            array(
                'id' => $id,
                'form' => $form->createView()
            )
        );
    }

    /**
     * @param Form $form
     * @param Page $page
     *
     * @return Boolean true for success
     */
    private function submitFormOk(Form $form, Page $page){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush(); 
            return true;
        }         

        // no submission detected yet, or invalid submission
        return false;
    }
}