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
use Reconnix\MenuManagerBundle\Classes\MenuManager\MenuManager;

/**
 * PageController
 */
class PageController extends Controller
{

    /**
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction($name){

        $page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findOneByName($name);
        $templates = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Template')->findAll();
        $pageRenderer = $this->container->get('page_renderer')->init($page, $templates);

        $blockRenderParams = array();
        if($name == 'newsroom'){
            $posts = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Post')->findAll();
            $blockRenderParams['posts'] = $posts;
        }

        // get the menu items
        $menuManager = $this->container->get('menu_manager');
        $menuItems = $menuManager->getMenuItems('ReconnixMainBundle:Menu\MenuItem');
        $blockRenderParams['menu'] = $menuItems;

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
            'body' => $page->getContent(),
        );

        $pageContent = $pageRenderer->render('page', $pageParams);

        return new Response($pageContent);
    }
}