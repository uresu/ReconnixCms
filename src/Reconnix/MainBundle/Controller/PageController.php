<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * PageController
 */
class PageController extends Controller
{

    /**
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction($name){
    	// fetch the requested Page object
    	$page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findOneByName($name);
    	$blocks = $page->getBlocks();
    	$blockContent = array();
    	foreach($blocks as $block){
    		$blockContent[] = array('name' => $block->getName(), 'content' => $block->getContent());
    	}

        $posts = null;

        if($page->getName() == 'newsroom'){
            // fetch the posts 
            $posts = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Post')->findAll();
        }

        
    	
        return $this->render('ReconnixMainBundle:Page:page.index.html.twig',
        	array(
        		'blocks' => $blockContent,
                'name' => $page->getName(),
        		'title' => $page->getTitle(),
        		'tagline' => $page->getTagline(),
                'subtagline' => $page->getSubtagline(),
        		'body' => $page->getContent(),
                'posts' => $posts,
        	)
        );
    }
}