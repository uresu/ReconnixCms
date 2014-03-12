<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller;

use Twig_Environment;
use Twig_Loader_Chain;
use Twig_Loader_Array;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * PageController
 */
class PageController extends Controller
{

    /**
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction($name){
        // fetch the templates
        $templates = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Template')->findAll();
        foreach($templates as $template){
            switch($template->getName()){
                case 'base':
                    $baseTwigContent = $template->getContent();
                    break;
                case 'page':
                    $pageTwigContent = $template->getContent();
                    break;
            }
        }

        // fetch the requested Page object
        $page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findOneByName($name);
        $posts = null;
        if($page->getName() == 'newsroom'){
            // fetch the posts 
            $posts = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Post')->findAll();
        }

        $blocks = $page->getBlocks();
        
        $blockContent = array();
        foreach($blocks as $block){
            $blockContent[$block->getName()] = array(
                'content' => $block->getContent(),
                'region' => $block->getRegion()
            );
        }

        $twigLoaders = array();
        $twigLoaders[] = new Twig_Loader_Array(array('base' => $baseTwigContent));
        $twigLoaders[] = new Twig_Loader_Array(array('page' => $pageTwigContent));
        foreach($blockContent as $block){
            $twigLoaders[] = new Twig_Loader_Array(array($block['region'] => $block['content']));
        }

        $loader = new Twig_Loader_Chain($twigLoaders);
        $twig = clone $this->get('twig');
        $twig->setLoader($loader);   


        // render blocks content to twig
        foreach($blockContent as &$block){
            $block['content'] = $twig->render($block['region']);
        }

        $render = $twig->render('page',
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

        return new Response($render);
    }

    /**
     * @return Response HTTP Response
     */
    public function newsroomAction($tag, $name){

        $page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findOneByName('post');
        $blocks = $page->getBlocks();
        $blockContent = array();
        foreach($blocks as $block){
            $blockContent[] = array('name' => $block->getName(), 'content' => $block->getContent());
        }
        
        // get the content for this particular news article
        $contentObj = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Post')->findOneByName($name);
        $content = $contentObj->getContent();


        return $this->render('ReconnixMainBundle:Page:page.index.html.twig',
            array(
                'blocks' => $blockContent,
                'name' => $page->getName(),
                'title' => $page->getTitle(),
                'tagline' => $page->getTagline(),
                'subtagline' => $page->getSubtagline(),
                'post_title' => $contentObj->getTitle(),
                'post_date' => $contentObj->getDate(),
                'body' => $content,
            )
        );
    }

}