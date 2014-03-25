<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Classes\PageRenderer;

use Twig_Environment;
use Twig_Loader_Array;
use Twig_Loader_Chain;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Reconnix\CmsBundle\Entity\Content\Page;
use Reconnix\CmsBundle\Entity\Content\Template;

/**
 * Renders Twig content by parsing strings that contain Twig syntax and converting into Twig via the Twig engine.
 */
class PageRenderer{

    /**
     * Doctrine service handle.
     * 
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
	private $doctrine;

    /**
     * Twig service handle.
     * 
     * @var \Twig_Environment
     */
	private $twig;

    /**
     * The Page the content belongs to.
     * 
     * @var \Reconnix\CmsBundle\Entity\Content\Page
     */
	private $page;

    /**
     * An array built up of Twig_Loaders
     * 
     * @var \Twig_Loader_Array
     */
	private $twigLoaders = array();
	
	/**
	 * Constructor.
	 *
	 * Injects all of the required services.
	 *
	 * @param \Doctrine\Bundle\DoctrineBundle\Registry 	$doctrine 	Doctrine service handle.
	 * @param \Twig_Environment							$twig 		Twig service handle.
	 */
	public function __construct(Registry $doctrine, Twig_Environment $twig){
		$this->doctrine = $doctrine;
		$this->twig = clone $twig;
	}

	/**
	 * A method to be chained on construction.
	 *
	 * Gets all Blocks and Templates and sends them off to have their string content loaded into a Twig_Loader_Array
	 *
	 * @param \Reconnix\CmsBundle\Entity\Content\Page 	$page 	The current Page, used to access its associated Blocks.
	 * @param array $templates Array of all templates created in the CMS.
	 *
	 * @return \Reconnix\CmsBundle\Classes\PageRenderer\PageRenderer 	This current instance, used for chaining with the Constructor.
	 */
	public function init(Page $page, array $templates){
		// send content to be loaded into Twig_Loader_Arrays
		$this->buildLoaders($templates);
		$this->buildLoaders($page->getBlocks());

		// send the chain of Twig_Loader_Arrays to be loaded into the Twig Engine. 
		$this->twig->setLoader(new Twig_Loader_Chain($this->twigLoaders));

		// return back to the constructor
		return $this;
	}

	/**
	 * Loop each piece of content that contains Twig syntax that needs to be parsed through the Twig engine.
	 *
	 * @param array $dbContent Array of string content as taken from the database
	 */
	private function buildLoaders($dbContent){
		foreach($dbContent as $content){
			$this->twigLoaders[] = new Twig_Loader_Array(array(strtolower($content->getName()) => $content->getContent())); 
		}
	}

	/**
	 * Wrapper to the \Twig_Environmet->render function.
	 *
	 * Returns content that has been parsed from string to Twig.
	 *
	 * @param string $template Name of the block/template to parse.
	 * @param array  $params   Array of parameters that the block/template might need.
	 *
	 * @return string Twig rendered content.
	 */
	public function render($template, array $params = null){
		$template = strtolower($template);
		return isset($params) ? $this->twig->render($template, $params) : $this->twig->render($template);
	}
}
