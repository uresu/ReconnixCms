<?php

namespace Reconnix\MainBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlocksController extends Controller
{
    public function indexAction(){

        return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.index.html.twig');
    }

    public function addAction(){

    	return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.add.html.twig');
    }

    public function editAction($id){

    	return $this->render('ReconnixMainBundle:Admin/Blocks:admin.blocks.edit.html.twig',
    		array("id" => $id)
    	);
    }
}