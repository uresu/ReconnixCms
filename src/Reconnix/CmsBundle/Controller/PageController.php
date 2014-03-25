<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Reconnix\CmsBundle\Classes\PageRenderer\PageRenderer;

use Reconnix\CmsBundle\Controller\Admin\CmsController;

/**
 * Renders a Page on the website.
 */
class PageController extends CmsController
{

    /**
     * Renders and displays a website page.
     *
     * The page to display is determined by the {name} passed via the URL.
     * 
     * @param string $name Name of the page to be rendered, as determined in the Admin.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction($name){

        // prepare the core objects
        $page = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Page')->findOneByName($name);
        $templates = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Template')->findAll();
        $pageRenderer = $this->container->get('page_renderer')->init($page, $templates);

        // get the logo filename
        $logo = $this->getLogoFilename();

        // get the navigation menu
        $menuItems = $this->getMenu();       

        // Certain Blocks have Twig variables within them. These needs parsing via the 'page_renderer' which uses the Twig Engine
        // This funtion builds an array of parameters as it goes, and eventually passing them all off to be rendered
        $blockRenderParams = array();
        $blockRenderParams['logo'] = 'files/'.$logo;
        $blockRenderParams['menu'] = $menuItems;

        // the newsroom page specifically has post related Twig variables that need parsing
        if($name == 'newsroom'){
            $posts = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Post')->findAll();
            $blockRenderParams['posts'] = $posts;
        }

        // Blocks ready to be rendered
        $renderedBlocks = $this->renderBlocks($page, $blockRenderParams);
        $blockMeta = $this->getBlockMeta($renderedBlocks);

        // define all Twig variables to be handled by the Twig template for a Page
        $pageParams = array(
            'blocks' => $renderedBlocks,
            'name' => $page->getName(),
            'title' => $page->getTitle(),
            'tagline' => $page->getTagline(),
            'subtagline' => $page->getSubtagline(),
            'blockMeta' => $blockMeta,
        );

        // render te content via the Twig engine
        $pageContent = $pageRenderer->render('base', $pageParams);
        return new Response($pageContent);
    }
}
