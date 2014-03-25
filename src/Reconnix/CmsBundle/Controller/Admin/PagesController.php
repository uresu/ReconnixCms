<?php

/**
 * This file is part of the Reconnix CMS package.
 *
 * Reconnix (c) <development@reconnix.com>
 */

namespace Reconnix\CmsBundle\Controller\Admin;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

use Reconnix\CmsBundle\Entity\Content\Page;
use Reconnix\CmsBundle\Entity\Content\Block;
use Reconnix\CmsBundle\Form\Type\PageType;

use Reconnix\CmsBundle\Controller\Admin\CmsController;

/**
 * Renders all CRUD related pages from \admin\pages.
 *
 * This Controller is registered as a Service, and all dependencies are injected via its construction.
 */
class PagesController extends CmsController
{

    /**
     * Doctrine service handle.
     * 
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected $doctrine;

    /**
     * FormFactory service handle.
     *
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $formFactory;

    /**
     * Templating service handle.
     *
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $templating;

    /**
     * RequestStack service handle.
     *
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $request;

    /**
     * Router service handle.
     *
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * Constructor.
     *
     * Injects all required services.
     *
     * @param \Doctrine\Bundle\DoctrineBundle\Registry                      $doctrine       Doctrine service handle.
     * @param \Symfony\Component\Form\FormFactoryInterface                  $formFactory    FormFactory service handle.
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface    $templating     Templating service handle.
     * @param \Symfony\Component\HttpFoundation\RequestStack                $request        RequestStack service handle.
     * @param \Symfony\Component\Routing\RouterInterface                    $router         Router service handle.
     */
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
     * Renders and displays the \admin\pages page.
     *
     * Displays all existing Pages. 
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function indexAction(){

        $entities = $this->doctrine->getRepository('ReconnixCmsBundle:Content\Page')->findAll();
        $pages = $this->getEntityFields($entities, array('id', 'title'));

        return $this->templating->renderResponse('ReconnixCmsBundle:Admin/Pages:admin.pages.index.html.twig', 
            array('pages' => $pages)
        );
    }

    /**
     * Renders and displays the \admin\pages\add page.
     *
     * Processes Form input for adding a new Block.
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */
    public function addAction(Request $request){
        // create an empty object to store the submitted data
        $page = new Page();
        // build the form, pass the empty object to store the user input
        $form = $this->formFactory->create(new PageType($page), $page);
       
        // check for a submitted form
        if($this->submitFormOk($form, $page)){
            // succesfull update, return to page index
            return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_index'));
        }

        // no submission detected, or invalid submission, display the form
        return $this->templating->renderResponse('ReconnixCmsBundle:Admin/Pages:admin.pages.add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Renders and displays the \admin\pages\edit\{id} page.
     *
     * Displays a prepopulated Form for the relevant Page.
     * Processes Form input for editing a Page.
     * 
     * @param integer $id The Page id to be edited.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Response.
     */ 
    public function editAction($id){
        // fetch the Page object
        $page = $this->doctrine->getRepository('ReconnixCmsBundle:Content\Page')->find($id);
        // create a pre-populated form
        $form = $this->formFactory->create(new PageType($page), $page);

        $blocks = $this->doctrine->getRepository('ReconnixCmsBundle:Content\Block')->findAll();
        $unusedBlocks = $page->getUnusedBlocks($blocks);
        $usedBlocks = $page->getBlocks();
        
        // check for a submitted form
        if($this->submitFormOk($form, $page)){
            // succesfull update, return to page index
            return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_index'));
        }

        // no submission detected, or invalid submission, display the pre-populated
        return $this->templating->renderResponse('ReconnixCmsBundle:Admin/Pages:admin.pages.edit.html.twig',
            array(
                'id' => $id,
                'form' => $form->createView(), 
                'usedBlocks' => $usedBlocks,
                'unusedBlocks' => $unusedBlocks,
            )
        );
    }

    /**
     * Delete a Page from the database.
     *
     * @param integer $id The ID of the Page to delete.
     * 
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Redirect.
     */ 
    public function deleteAction($id){
        // load the entity for deleting
        $page = $this->doctrine->getRepository('ReconnixCmsBundle:Content\Page')->find($id);

        // persist
        $em = $this->doctrine->getManager();
        $em->remove($page);
        $em->flush();       

        return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_index'));
    }

    /**
     * Add a single Block to a Page.
     *
     * @param integer $blockId The ID of the Block to add 
     * @param integer $pageId The ID of the Page being added to
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Redirect.
     */
    public function addBlockAction($blockId, $pageId){
        // add the block
        $page = $this->doctrine->getRepository('ReconnixCmsBundle:Content\Page')->find($pageId);
        $page->addBlock($this->doctrine->getRepository('ReconnixCmsBundle:Content\Block')->find($blockId));

        // persist
        $em = $this->doctrine->getManager();
        $em->persist($page);
        $em->flush();        

        return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_edit', array(
            "id" => $pageId)));
    }

    /**
     * Delete a single Block to a Page.
     *
     * @param integer $blockId The ID of the Block to add 
     * @param integer $pageId The ID of the Page being added to
     *
     * @return \Symfony\Component\HttpFoundation\Response An HTTP Redirect.
     */
    public function deleteBlockAction($blockId, $pageId){
        // remove the block
        $page = $this->doctrine->getRepository('ReconnixCmsBundle:Content\Page')->find($pageId);
        $page->removeBlock($this->doctrine->getRepository('ReconnixCmsBundle:Content\Block')->find($blockId));

        // persist
        $em = $this->doctrine->getManager();
        $em->persist($page);
        $em->flush();    

        return new RedirectResponse($this->router->generate('reconnix_main_admin_pages_edit', array(
            "id" => $pageId)));
    }
 }
