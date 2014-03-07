<?php

namespace Reconnix\ContentWizardBundle\Classes\FormManager\Concrete;



use Reconnix\ContentWizardBundle\Entity\Content\Content;
use Reconnix\ContentWizardBundle\Classes\FormManager\FormManager;
use Reconnix\ContentWizardBundle\Form\Type\PostType;

class PostFormManager extends FormManager{
	
	public function build(Content $content = null){
		return $this->formFactory->create(new PostType(), $content);
	}
}