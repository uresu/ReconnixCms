<?php

/*
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\MainBundle\Controller\Admin;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

use Reconnix\MainBundle\Entity\Content\Page;
use Reconnix\MainBundle\Entity\Content\Block;
use Reconnix\MainBundle\Form\Type\PageType;

/**
 * PagesController
 */
class PagesController 
{

    protected $doctrine;
    protected $formFactory;
    protected $templating;
    protected $request;
    protected $router;

    public function __construct(Registry $doctrine,
                                FormFactoryInterface $formFactory,
                                EngineInterface $templating,
                                RequestStack $request,
                                RouterInterface $router){
        $this->doctrine    = $doctrine;
        $this->formFactory = $formFactory;
        $this->templating  = $templating;
        $this->request     = $request;
        $this->router      = $router;
    }

    /**
     * Display list of existing Pages
     *
     * @return Reponse HTTP Repsonse 
     */
    public function indexAction(){
        // fetch all Pages
        //$pageObjs = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->findAll();
        $pageObjs = $this->doctrine->getRepository('ReconnixMainBundle:Content\Page')->findAll();
        // disect out the id and name of each Page object for passing to the view
        $pages = array();
        foreach($pageObjs as $pageObj){
            $pages[] = array(
                'id' => $pageObj->getId(),
                'title' => $pageObj->getTitle()
            );
        }

        return $this->templating->renderResponse('ReconnixMainBundle:Admin/Pages:admin.pages.index.html.twig', 
            array('pages' => $pages)
        );
    }

    /**
     * @param Request $request The HTTP Request
     * 
     * @return Reponse HTTP Repsonse 
     */
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $page = new Page();
        // build the form, pass the empty object to store the user input
        $form = $this->formFactory->create(new PageType($page), $page);
       
        // check for a submitted form
        if(self::submitFormOk($form, $page)){
            // succesfull update, return to page index
            return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->templating->renderResponse('ReconnixMainBundle:Admin/Pages:admin.pages.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Reponse HTTP Repsonse 
     */ 
    public function editAction($id){
        // fetch the Page object
        //$page = $this->getDoctrine()->getRepository('ReconnixMainBundle:Content\Page')->find($id);
        $page = $this->doctrine->getRepository('ReconnixMainBundle:Content\Page')->find($id);
        // create a pre-populated form
        $form = $this->formFactory->create(new PageType($page), $page);


        $blocks = $this->doctrine->getRepository('ReconnixMainBundle:Content\Block')->findAll();
        $unusedBlocks = $page->getUnusedBlocks($blocks);
        $usedBlocks = $page->getBlocks();
        
        // check for a submitted form
        if(self::submitFormOk($form, $page)){
            // succesfull update, return to page index
            return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_index'));
        }

        // no submission detected, or invalid submission, display the pre-populated
        return $this->templating->renderResponse('ReconnixMainBundle:Admin/Pages:admin.pages.edit.html.twig',
            array(
                'id' => $id,
                'form' => $form->createView(), 
                'usedBlocks' => $usedBlocks,
                'unusedBlocks' => $unusedBlocks,
            )
        );
    }

    /**
     * @param Form $form
     * @param Page $page
     *
     * @return Boolean true for success
     */
    private function submitFormOk($form, Page $page){
        // handle form submission
        $form->handleRequest(Request::createFromGlobals());
        if($form->isValid()){
            // valid form submission
            //$em = $this->getDoctrine()->getManager();
            $em = $this->doctrine->getManager();
            $em->persist($page);
            $em->flush(); 
            return true;
        }         

        // no submission detected yet, or invalid submission
        return false;
    }

    /**
     * @param integer $id The Post id
     * 
     * @return Reponse HTTP Repsonse 
     */ 
    public function deleteAction($id){
        // load the entity for deleting
        $page = $this->doctrine->getRepository('ReconnixMainBundle:Content\Page')->find($id);
        // create entity manager and run the delete command
        $em = $this->doctrine->getManager();
        $em->remove($page);
        $em->flush();       

        return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_index'));
    }

    /**
     * @param int 
     * @param int
     *
     * @return Response HTTP Response
     */
    public function addBlockAction($blockId, $pageId){
        $page = $this->doctrine->getRepository('ReconnixMainBundle:Content\Page')->find($pageId);
        $page->addBlock($this->doctrine->getRepository('ReconnixMainBundle:Content\Block')->find($blockId));
        $em = $this->doctrine->getManager();
        $em->persist($page);
        $em->flush();        

        return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_edit', array(
            "id" => $pageId)));
    }  

    /**
     * @param int 
     * @param int
     *
     * @return Response HTTP Response
     */
    public function deleteBlockAction($blockId, $pageId){
        $page = $this->doctrine->getRepository('ReconnixMainBundle:Content\Page')->find($pageId);
        $page->removeBlock($this->doctrine->getRepository('ReconnixMainBundle:Content\Block')->find($blockId));
        $em = $this->doctrine->getManager();
        $em->persist($page);
        $em->flush();    

        return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_edit', array(
            "id" => $pageId)));
    }  
}