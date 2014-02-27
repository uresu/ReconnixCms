<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Page;

class PagesController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.index.html.twig');
    }

    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $page = new Page();
        // create Page form and return a handle to it
        $form = self::buildPageForm($page);
        // handle form submission
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            self::persistFormData($page);
            // return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_pages_index'));
        }

        // no submission detected, or invalid submission, display the form

        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    private function buildPageForm(Page $page){

        $form = $this->createFormBuilder($page)
            ->add('name', 'text')
            ->add('title', 'text')
            ->add('tagline', 'text')
            ->add('blocks', 'entity', array(
                'class' => 'ReconnixMainBundle:Block',
                'multiple' => true,
                'expanded' => true,
                'property' => 'name',
            ))
            ->add('save', 'submit')
            ->getForm();

        return $form;
    }

    private function persistFormData(Page $page){
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();       
    }

    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.edit.html.twig',
    		array("id" => $id)
    	);
    }
}