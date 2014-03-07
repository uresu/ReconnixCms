<?php

namespace Reconnix\DepInjBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

use Reconnix\ContentWizardBundle\Classes\ContentWizard;
use Reconnix\ContentWizardBundle\Classes\Page;

class DefaultController extends ContainerAware
{
    public function indexAction()
    {
        $c = $this->container->get('content_wizard');

        $c->setContentType('page');
        $form = $c->createForm();

        //print_r($c);

        return $this->container->get('templating')->renderResponse('ReconnixDepInjBundle:Default:index.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }


}