<?php

namespace Reconnix\MainBundle\Classes\PageRenderer;

use Twig_Environment;
use Twig_Loader_Array;
use Twig_Loader_Chain;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Reconnix\MainBundle\Entity\Content\Page;
use Reconnix\MainBundle\Entity\Content\Template;

class PageRenderer{

	private $doctrine;
	private $twig;
	private $page;
	private $blocks;
	private $templates = array();
	private $twigLoaders = array();
	
	public function __construct(Registry $doctrine, Twig_Environment $twig){
		$this->doctrine = $doctrine;
		$this->twig = clone $twig;
	}

	public function init(Page $page, array $templates){
		$this->page = $page;
		$this->blocks = $page->getBlocks();		
		$this->templates = $templates;

		$this->buildLoaders($this->templates);
		$this->buildLoaders($this->blocks);

		return $this;
	}

	private function buildLoaders($dbContent){
		foreach($dbContent as $content){
			$this->twigLoaders[] = new Twig_Loader_Array(array(strtolower($content->getName()) => $content->getContent())); 
		}

		$this->twig->setLoader(new Twig_Loader_Chain($this->twigLoaders));
	}

	public function render($template, array $params = null){
		$template = strtolower($template);
		return isset($params) ? $this->twig->render($template, $params) : $this->twig->render($template);
	}
}