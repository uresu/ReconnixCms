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

        $blockRenderParams = array();

        $page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findOneByName($name);
        $templates = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Template')->findAll();
        $pageRenderer = $this->container->get('page_renderer')->init($page, $templates);

        // get the logo filename to pass to the header block
        $logoPath = $this->getDoctrine()->getRepository('ReconnixMainBundle:Configuration\Configuration')->find(1)->getLogoPath();
        $blockRenderParams['logo'] = 'files/'.$logoPath;

        if($name == 'newsroom'){
            $posts = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Post')->findAll();
            $blockRenderParams['posts'] = $posts;
        }

        // get the menu items
        /*
        $menuManager = $this->container->get('menu_manager');
        $menuItems = $menuManager->getMenuItems('ReconnixMainBundle:Menu\MenuItem');
        $blockRenderParams['menu'] = $menuItems;
        */

        $em = $this->getDoctrine()->getManager();
        $menuItems = $em->getRepository('ReconnixMainBundle:Menu\MenuItem')->getMenuItems();
        $blockRenderParams['menu'] = $menuItems;

        $blockBackgroundColors = array();
        $blocks = $page->getBlocks();
        foreach($blocks as &$block){
            $blockMeta[$block->getRegion()]['background'] = $block->getBackground();
            $blockMeta[$block->getRegion()]['classList'] = $block->getClassList();
            $block->setContent($pageRenderer->render($block->getName(), $blockRenderParams));
        }


        $pageParams = array(
            'blocks' => $blocks,
            'name' => $page->getName(),
            'title' => $page->getTitle(),
            'tagline' => $page->getTagline(),
            'subtagline' => $page->getSubtagline(),
            'blockMeta' => $blockMeta,
        );

        $pageContent = $pageRenderer->render('base', $pageParams);

        return new Response($pageContent);
    }
}