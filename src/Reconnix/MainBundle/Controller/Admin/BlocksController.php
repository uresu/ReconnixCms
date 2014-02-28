<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Block;
use Reconnix\MainBundle\Form\Type\BlockType;

class BlocksController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.index.html.twig');
    }

    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $block = new Block();
        $form = $this->createForm(new BlockType(), $block);
        // handle form submission
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            self::persistFormData($block);
            // return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_blocks_index'));
        }

        // no submission detected, or invalid submission
        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.add.html.twig',
            array('form' => $form->createView())
        );
    }

    private function persistFormData(Block $block){
            $em = $this->getDoctrine()->getManager();
            $em->persist($block);
            $em->flush();       
    }

    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.edit.html.twig',
    		array("id" => $id)
    	);
    }
}