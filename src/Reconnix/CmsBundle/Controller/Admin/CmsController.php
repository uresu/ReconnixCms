<?php

/** 
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Reconnix\CmsBundle\Entity\Content\Page;
/**
 * A base controller for the CMS controllers.
 *
 * Defines all common functionality required amongst the CMS pages. 
 * Technically this acts more like a base 'model' and not a 'controller'.
 * It is not called directly from any routing configuration.
 */
class CmsController extends Controller{

	/**
     * Loops the Entites to extract the requested properties of each Entity and return an array.
     *
     * @param mixed[] 	$entities 	An array of entites.
     * @param string[]	$fields 	An array of the requested fields
     *
     * @return array An array of arrays, each containing the requested properties of the Entity.
     */
    protected function getEntityFields(array $entities, array $fields){
        
        $returnArray = array();

        for($i = 0; $i < count($entities); $i++){
        	foreach($fields as $field){
        		$getMethod = sprintf('get%s', ucfirst($field));
        		$returnArray[$i][$field] = call_user_func(array($entities[$i], $getMethod));
        	}
    	}

        return $returnArray;
    }

    /**
     * Check for Form submission and process if detected.
     *
     * Validation on the populated Entity is performed here, prior to persistence.
     *
     * @param \Symfony\Component\Form\Form $form The current Form object.
     * @param mixed $entity The current Entity object that the Form represents.
     * @param array $defaults Default values to submit if left blank by the User: "field" => "value"
     *
     * @return Boolean true for successful submission, false for unsuccessful/no submission.
     */
    protected function submitFormOk(Form $form, $entity, array $defaults = null){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
        	if(!is_null($defaults)){
        		// set any default values
        		foreach($defaults as $field => $value){
        			$getMethod = sprintf('get%s', ucfirst($field));
        			if(call_user_func(array($entity, $getMethod)) === null){
        				$setMethod = sprintf('set%s', ucfirst($field));
        				call_user_func_array(array($entity, $setMethod), array($value));
        			}
        		}
        	}

            // persist
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush(); 

            return true;
        }         

        // no submission detected yet, or invalid submission
        return false;
    }

    /**
     * Get the Logo filename.
     *
     * The function assumes that the logo belongs to the table row where 'name' == 'main'.
     *
     * @return string
     */
    protected function getLogoFilename(){
    	return $this->getDoctrine()->getRepository('ReconnixCmsBundle:Configuration\Configuration')->findOneByName('main')->getLogoPath();
    }

    /**
     * Get the array of 'front end' menu items.
     *
     * The array represents the menu that is displayed in the navigation area of the website.
     *
     * @return array An array of MenuItems
     */
    protected function getMenu(){
    	$em = $this->getDoctrine()->getManager();
        return $em->getRepository('ReconnixCmsBundle:Menu\MenuItem')->getMenuItems();
    }

    /**
     * Render the content of Page Blocks by parsing through the Twig engine.
     *
     * @param \Reconnix\CmsBundle\Entity\Content\Page $page The current Page object being requested.
     * @param array $params Twig variables to be rendered by the Twig engine.
     *
     * @return array An array of rendered Blocks
     */
    protected function renderBlocks(Page $page, array $params){
    	
    	$pageRenderer = $this->container->get('page_renderer');
    	$blocks = $page->getBlocks();

    	foreach($blocks as &$block){
            $block->setContent($pageRenderer->render($block->getName(), $params));
        }

        return $blocks;
    }

    /**
     * Get the meta data associated with each Block.
	 *
	 * TODO This is poor design and uses hardcoded field values. It should read all Meta associated with each Block from a BlockMeta table.
     *
     * @param \Reconnix\CmsBundle\Entity\Content\Block[] $blocks array of all Blocks associated to the current Page
     *
     * @return array[] An array of arrays, each containing the meta data for a Block
     */
    protected function getBlockMeta($blocks){

    	$returnArray = array();

        foreach($blocks as $block){
            $returnArray[$block->getRegion()]['background'] = $block->getBackground();
            $returnArray[$block->getRegion()]['classList'] = $block->getClassList();
        }

        return $returnArray;
    }
}