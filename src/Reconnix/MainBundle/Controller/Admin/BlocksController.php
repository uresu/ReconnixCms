<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Block;

class BlocksController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.index.html.twig');
    }

    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $block = new Block();

        // create the User form
        $form = $this->createFormBuilder($block)
            ->add('name', 'text')
            ->add('content', 'textarea', array('attr' => array('cols' => '100', 'rows' => '5')))
            ->add('save', 'submit')
            ->getForm();

        // handle form submission
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($block);
            $em->flush();

            return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
        }

        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.add.html.twig',
            array('form' => $form->createView())
        );
    }

    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.edit.html.twig',
    		array("id" => $id)
    	);
    }
}