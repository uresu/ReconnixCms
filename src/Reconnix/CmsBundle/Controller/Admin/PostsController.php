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
use Reconnix\CmsBundle\Entity\Content\Post;
use Reconnix\CmsBundle\Form\Type\PostType;

/**
 * PostsController
 */
class PostsController extends Controller
{
    
    /**
     * Display list of existing Posts
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
        // fetch all Posts
        $postObjs = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Post')->findAll();
        // disect out the id and name of each Post object for passing to the view
        $posts = array();
        foreach($postObjs as $postObj){
            $posts[] = array(
                'id' => $postObj->getId(),
                'title' => $postObj->getTitle()
            );
        }

        return $this->render('ReconnixCmsBundle:Admin/Posts:admin.posts.index.html.twig', 
            array('posts' => $posts)
        );
    }

    /**
     * @param Request $request The HTTP Request
     * 
     * @return Reponse HTTP Repsonse 
     */    
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $post = new Post();
        // build the form, pass the empty object to store the user input
        $form = $this->createForm(new PostType(), $post);
        
        // check for a submitted form
        if(self::submitFormOk($form, $post)){
            // succesfull update, return to post index
            return $this->redirect($this->generateUrl('reconnix_main_admin_posts_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixCmsBundle:Admin/Posts:admin.posts.add.html.twig',
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
        // fetch the Post object
        $post = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Post')->find($id);
        // create a pre-populated form
        $form = $this->createForm(new PostType(), $post);

        // check for a submitted form
        if(self::submitFormOk($form, $post)){
            // succesfull update, return to post index
            return $this->redirect($this->generateUrl('reconnix_main_admin_posts_index'));
        }

        // no submission detected, or invalid submission, display the pre-populated
        return $this->render('ReconnixCmsBundle:Admin/Posts:admin.posts.edit.html.twig',
            array(
                'id' => $id,
                'form' => $form->createView()
            )
        );
    }

    /**
     * @param Form $form
     * @param Post $post
     *
     * @return Boolean true for success
     */
    private function submitFormOk(Form $form, Post $post){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
            // valid form submission
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush(); 
            return true;
        }         

        // no submission detected yet, or invalid submission
        return false;
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Reponse HTTP Repsonse 
     */ 
    public function deleteAction($id){
        // load the entity for deleting
        $post = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Post')->find($id);
        // create entity manager and run the delete command
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();       

        return $this->redirect($this->generateUrl('reconnix_main_admin_posts_index'));
    } 
}
