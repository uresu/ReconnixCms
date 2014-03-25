<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Reconnix\CmsBundle\Classes\PageRenderer\PageRenderer;

use Reconnix\CmsBundle\Controller\Admin\CmsController;

/**
 * Renders a Post on the website.
 */
class PostController extends CmsController
{

    /**
     * Renders and displays a website page that specifically displays a single post.
     *
     * The post to display is determined by the {title} passed via the URL.
     * 
     * @param string $tag The tag to which the post belongs. Currently unused by may be in the future. Always provides a cleaner URL.
     * @param string $title Title of the post to be rendered, as determined in the Admin.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction($tag, $title){

        // prepare the core objects
        $page = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Page')->findOneByName('post');
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

        // get this particular post and set Twig variables to be parsed
        $post = $this->getDoctrine()->getRepository('ReconnixCmsBundle:Content\Post')->findOneByName($title);
        $blockRenderParams['post_title'] = $post->getTitle();
        $blockRenderParams['post_date'] = $post->getDate();
        $blockRenderParams['body'] = $post->getContent();

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