<?php

namespace Reconnix\MenuManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ReconnixMenuManagerBundle:Default:index.html.twig', array('name' => $name));
    }
}
