<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PagesController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.index.html.twig');
    }

    public function addAction(Request $request){

    	return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.add.html.twig');
    }

    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Pages:admin.pages.edit.html.twig',
    		array("id" => $id)
    	);
    }
}