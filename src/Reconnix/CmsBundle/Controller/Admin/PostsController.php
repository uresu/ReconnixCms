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
use Reconnix\CmsBundle\Entity\Content\Post;
use Reconnix\CmsBundle\Form\Type\PostType;

use Reconnix\CmsBundle\Controller\Admin\CmsController;

/**
 * Renders all CRUD related pages from \admin\posts.
 */
class PostsController extends CmsController
{
    
    /**
     * Renders and displays the \admin\posts page.
     *
     * Displays all existing Posts. 
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction(){

        $entities = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Post')->findAll();
        $posts = $this->getEntityFields($entities, array('id', 'title'));

        return $this->render('ReconnixCmsBundle:Admin/Posts:admin.posts.index.html.twig', 
            array('posts' => $posts)
        );
    }

    /**
     * Renders and displays the \admin\posts\add page.
     *
     * Processes Form input for adding a new Post.
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
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
        return $this->render('ReconnixCmsBundle:Admin/Posts:admin.posts.form.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Renders and displays the \admin\posts\edit\{id} page.
     *
     * Displays a prepopulated Form for the relevant Post.
     * Processes Form input for editing a Post.
     * 
     * @param integer $id The Post id to be edited.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
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
        return $this->render('ReconnixCmsBundle:Admin/Posts:admin.posts.form.html.twig',
            array(
                'id' => $id,
                'form' => $form->createView()
            )
        );
    }

    /**
     * Delete a Post from the database.
     *
     * @param integer $id The ID of the Post to delete.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Redirect.
     */ 
    public function deleteAction($id){
        // load the entity for deleting
        $post = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Post')->find($id);
        
        // persist
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();       

        return $this->redirect($this->generateUrl('reconnix_main_admin_posts_index'));
    } 


}
