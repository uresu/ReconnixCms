<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction(){
    	
        return $this->render('ReconnixMainBundle:Admin:admin.index.html.twig');
    }
}