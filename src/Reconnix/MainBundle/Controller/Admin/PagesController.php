<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.index.html.twig');
    }

    public function addAction(){

    	return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.add.html.twig');
    }

    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.edit.html.twig',
    		array("id" => $id)
    	);
    }
}