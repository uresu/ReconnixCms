<?php

namespace Reconnix\ContentWizardBundle\Classes\FormManager;

use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Reconnix\ContentWizardBundle\Entity\Content\Content;

abstract class FormManager{

	protected $formFactory;
	protected $doctrine;

	public function __construct(FormFactoryInterface $formFactory, Registry $doctrine){
		$this->formFactory = $formFactory;
		$this->doctrine = $doctrine;
	}

	abstract public function build(Content $content = null);

	public function submit(Content $content){
		$em = $this->doctrine->getManager();
		$em->persist($content);
		$em->flush();
	}
}