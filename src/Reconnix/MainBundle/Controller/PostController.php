<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Reconnix\MainBundle\Classes\PageRenderer\PageRenderer;

/**
 * PageController
 */
class PostController extends Controller
{

    /**
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction($tag, $title){

        $page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findOneByName('post');
        $templates = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Template')->findAll();
        $pageRenderer = $this->container->get('page_renderer')->init($page, $templates);

        // get this particular post
        $post = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Post')->findOneByName($title);

        $blockRenderParams = array(
            'post_title' => $post->getTitle(),
            'post_date' => $post->getDate(),
            'body' => $post->getContent()
        );


        $blocks = $page->getBlocks();
        foreach($blocks as &$block){
            $block->setContent($pageRenderer->render($block->getName(), $blockRenderParams));
        }

        $pageParams = array(
            'blocks' => $blocks,
            'name' => $page->getName(),
            'title' => $page->getTitle(),
            'tagline' => $page->getTagline(),
            'subtagline' => $page->getSubtagline(),
        );

        $pageContent = $pageRenderer->render('page', $pageParams);

        return new Response($pageContent);
    }
}