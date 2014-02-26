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

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSTemplate')->getTemplatesQB($order, $sequence, $filtr);

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
     * @Route("/create", name="cmstemplate_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new CMSTemplate();

        $form   = $this->createForm(new CMSTemplateType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Dodawanie szablonu zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSTemplate:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to create a new CMSTemplate entity.
     *
     * @Route("/new", name="cmstemplate_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $entity = new CMSTemplate();
        $form = $this->createForm(new CMSTemplateType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSTemplate:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
                );

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to edit an existing CMSTemplate entity.
     *
     * @Route("/{id}/edit", name="cmstemplate_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
        }

        $editForm = $this->createForm(new CMSTemplateType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSTemplate:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Edits an existing CMSTemplate entity.
     *
     * @Route("/{id}/update", name="cmstemplate_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
        }

        $editForm = $this->createForm(new CMSTemplateType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Edycja szablonu zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSTemplate:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Deletes a CMSTemplate entity.
     *
     * @Route("/delete", name="cmstemplate_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
            }

            $em->remove($entity);
        }

        try {
            $em->flush();

            if (count($arrayId) > 1) {
                $message = 'Usuwanie szablonów zakończyło się powodzeniem';
            }
            else {
                $message = 'Usuwanie szablonu zakończyło się powodzeniem';
            }

            $response = array(
                "response" => true,
                "message" => $message
                );
        } catch (\Exception $e) {
            if (count($arrayId) > 1) {
                $message = 'Usuwanie szablonów zakończyło się niepowodzeniem';
            }
            else {
                $message = 'Usuwanie szablonu zakończyło się niepowodzeniem';
            }

            $response = array(
                "response" => false,
                "message" => $message
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Change state a CMSTemplate entity.
     *
     * @Route("/state", name="cmstemplate_state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSTemplate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSTemplate entity.');
        }

        if ($entity->getIsPublic()) {
            $entity->setIsPublic(false);
        }
        else {
            $entity->setIsPublic(true);
        }

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => 'Zmiana stanu szablonu zakończyła się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Zmiana stanu szablonu zakończyła się niepowodzeniem'
                );
        }

        return new Response(json_encode($response));
    }

}
