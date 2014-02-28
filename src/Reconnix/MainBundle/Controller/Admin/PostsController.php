<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Content\Post;
use Reconnix\MainBundle\Form\Type\PostType;

/**
 * PostsController
 */
class PostsController extends Controller
{
    
    /**
     * @return Response HTTP Repsonse 
     */
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Posts:admin.posts.index.html.twig');
    }

    /**
     * @param Request $request The HTTP Request
     * 
     * @return Repsonse HTTP Repsonse 
     */    
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $post = new Post();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new PostType(), $post);
        // handle form submission
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush(); 
            // return to posts index
            return $this->redirect($this->generateUrl('reconnix_main_admin_posts_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixMainBundle:Admin/Posts:admin.posts.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Response HTTP Repsonse 
     */ 
    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Posts:admin.posts.edit.html.twig',
    		array("id" => $id)
    	);
    }
}