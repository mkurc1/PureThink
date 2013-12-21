<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentOnPageHasElement;
use My\CMSBundle\Form\CMSComponentOnPageHasElementType;
use Symfony\Component\HttpFoundation\Response;

use My\BackendBundle\Pagination\Pagination as Pagination;

/**
 * CMSComponentOnPageHasElement controller.
 *
 * @Route("/component/element")
 */
class CMSComponentOnPageHasElementController extends Controller
{
    /**
     * Lists all CMSComponentOnPageHasElement entities.
     *
     * @Route("/", name="cmscomponentonpagehaselement")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page = (int)$request->get('page', 1);
        $order = $request->get('order', 'a.name');
        $sequence = $request->get('sequence', 'ASC');
        $filtr = $request->get('filtr');
        $sublistId = (int)$request->get('sublistId');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->getElements($order, $sequence, $filtr, $sublistId);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $page,
            $rowsOnPage
        );

        $list = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_list.html.twig', array('entities' => $pagination, 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list" => $list,
            "pagination" => Pagination::helper($pagination),
            "response" => true
            );

        return new Response(json_encode($response));
    }

    /**
     * Creates a new CMSComponentOnPageHasElement entity.
     *
     * @Route("/create", name="cmscomponentonpagehaselement_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $sublistId = (int)$request->get('sublistId');
        $em = $this->getDoctrine()->getManager();

        $entity = new CMSComponentOnPageHasElement();
        $entity->setComponentOnPage($em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($sublistId));

        $form = $this->createForm(new CMSComponentOnPageHasElementType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Dodawanie kolumny zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to create a new CMSComponentOnPageHasElement entity.
     *
     * @Route("/new", name="cmscomponentonpagehaselement_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $entity = new CMSComponentOnPageHasElement();
        $form = $this->createForm(new CMSComponentOnPageHasElementType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
                );

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to edit an existing CMSComponentOnPageHasElement entity.
     *
     * @Route("/{id}/edit", name="cmscomponentonpagehaselement_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
        }

        $editForm = $this->createForm(new CMSComponentOnPageHasElementType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Edits an existing CMSComponentOnPageHasElement entity.
     *
     * @Route("/{id}/update", name="cmscomponentonpagehaselement_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
        }

        $editForm = $this->createForm(new CMSComponentOnPageHasElementType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Edycja kolumny zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Deletes a CMSComponentOnPageHasElement entity.
     *
     * @Route("/delete", name="cmscomponentonpagehaselement_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
            }

            $em->remove($entity);
        }

        try {
            $em->flush();

            if (count($arrayId) > 1) {
                $message = 'Usuwanie kolumn zakończyło się powodzeniem';
            }
            else {
                $message = 'Usuwanie kolumny zakończyło się powodzeniem';
            }

            $response = array(
                "response" => true,
                "message" => $message
                );
        } catch (\Exception $e) {
            if (count($arrayId) > 1) {
                $message = 'Usuwanie kolumn zakończyło się niepowodzeniem';
            }
            else {
                $message = 'Usuwanie kolumny zakończyło się niepowodzeniem';
            }

            $response = array(
                "response" => false,
                "message" => $message
                );
        }

        return new Response(json_encode($response));
    }
}
