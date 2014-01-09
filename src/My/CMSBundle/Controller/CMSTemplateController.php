<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSTemplate;
use My\CMSBundle\Form\CMSTemplateType;
use Symfony\Component\HttpFoundation\Response;

use My\BackendBundle\Pagination\Pagination as Pagination;

/**
 * CMSTemplate controller.
 *
 * @Route("/template")
 */
class CMSTemplateController extends Controller
{

    /**
     * Lists all CMSTemplate entities.
     *
     * @Route("/", name="cmstemplate")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page = (int)$request->get('page', 1);
        $order = $request->get('order', 'a.name');
        $sequence = $request->get('sequence', 'ASC');
        $filtr = $request->get('filtr');
        $languageId = $request->get('languageId');
        $groupId = $request->get('groupId');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSTemplate')->getTemplates($order, $sequence, $filtr);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $page,
            $rowsOnPage
        );

        $list = $this->renderView('MyCMSBundle:CMSTemplate:_list.html.twig', array('entities' => $pagination, 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list" => $list,
            "pagination" => Pagination::helper($pagination),
            "response" => true
            );

        return new Response(json_encode($response));
    }

    /**
     * Creates a new CMSTemplate entity.
     *
     * @Route("/", name="cmstemplate_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSTemplate:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CMSTemplate();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmstemplate_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a CMSTemplate entity.
    *
    * @param CMSTemplate $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CMSTemplate $entity)
    {
        $form = $this->createForm(new CMSTemplateType(), $entity, array(
            'action' => $this->generateUrl('cmstemplate_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CMSTemplate entity.
     *
     * @Route("/new", name="cmstemplate_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CMSTemplate();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CMSTemplate entity.
     *
     * @Route("/{id}", name="cmstemplate_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CMSTemplate entity.
     *
     * @Route("/{id}/edit", name="cmstemplate_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CMSTemplate entity.
    *
    * @param CMSTemplate $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CMSTemplate $entity)
    {
        $form = $this->createForm(new CMSTemplateType(), $entity, array(
            'action' => $this->generateUrl('cmstemplate_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CMSTemplate entity.
     *
     * @Route("/{id}", name="cmstemplate_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSTemplate:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cmstemplate_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CMSTemplate entity.
     *
     * @Route("/{id}", name="cmstemplate_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cmstemplate'));
    }

    /**
     * Creates a form to delete a CMSTemplate entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cmstemplate_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
