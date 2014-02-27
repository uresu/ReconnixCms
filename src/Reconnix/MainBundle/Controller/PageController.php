<?php

namespace Reconnix\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction($name){
    	
        return $this->render('ReconnixMainBundle:Page:page.index.html.twig');
    }
}