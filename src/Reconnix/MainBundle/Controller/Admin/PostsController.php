<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Reconnix\MainBundle\Entity\Content\Post;
use Reconnix\MainBundle\Form\Type\PostType;

class PostsController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Posts:admin.posts.index.html.twig');
    }

    public function addAction(Request $request){

        // create an empty object to store the submitted data
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);

        // handle form submission
        $form->handleRequest($request);
        if($form->isValid()){
            // valid form submission
            self::persistFormData($post);
            // return to block index
            return $this->redirect($this->generateUrl('reconnix_main_admin_posts_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->render('ReconnixMainBundle:Admin/Posts:admin.posts.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    private function persistFormData(Post $post){
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();       
    }

    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Posts:admin.posts.edit.html.twig',
    		array("id" => $id)
    	);
    }
}