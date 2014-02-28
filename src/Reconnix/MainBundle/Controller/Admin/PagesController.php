<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Page;
use Reconnix\MainBundle\Form\Type\PageType;

class PagesController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.index.html.twig');
    }

    public function addAction(Request $request){

        // create an empty object to store the submitted data
        $page = new Page();
        $form = $this->createForm(new PageType(), $page);

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