<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$container->setParameter('form_manager_factory.class', 'Reconnix\ContentWizardBundle\Classes\FormManager\FormManagerFactory');
$container->setDefinition('form_manager_factory', new Definition(
	'%form_manager_factory.class%',
	array(new Reference('service_container'))
));

$container->setParameter('content_factory.class', 'Reconnix\ContentWizardBundle\Classes\Content\ContentFactory');
$container->setDefinition('content_factory', new Definition(
	'%content_factory.class%',
	array(new Reference('service_container'))
));

$container->setParameter('page_form_manager.class', 'Reconnix\ContentWizardBundle\Classes\FormManager\Concrete\PageFormManager');
$container->setDefinition('page_form_manager', new Definition(
	'%page_form_manager.class%', 
	array(new Reference('form.factory'),
		  new Reference('doctrine'))
));


$container->setParameter('page.class', 'Reconnix\ContentWizardBundle\Entity\Content\Page');
$container->setDefinition('page', new Definition(
	'%page.class%'
));


$container->setParameter('post_form_manager.class', 'Reconnix\ContentWizardBundle\Classes\FormManager\Concrete\PostFormManager');
$container->setDefinition('post_form_manager', new Definition(
	'%post_form_manager.class%', 
	array(new Reference('form.factory'),
		  new Reference('doctrine'))
));

$container->setParameter('post.class', 'Reconnix\ContentWizardBundle\Entity\Content\Post');
$container->setDefinition('post', new Definition(
	'%post.class%'
));

$container->setParameter('block_form_manager.class', 'Reconnix\ContentWizardBundle\Classes\FormManager\Concrete\BlockFormManager');
$container->setDefinition('block_form_manager', new Definition(
	'%block_form_manager.class%', 
	array(new Reference('form.factory'),
		  new Reference('doctrine'))
));

$container->setParameter('block.class', 'Reconnix\ContentWizardBundle\Entity\Content\Block');
$container->setDefinition('block', new Definition(
	'%block.class%'
));