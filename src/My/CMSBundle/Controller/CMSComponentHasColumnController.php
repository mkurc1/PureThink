<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentHasColumn;
use My\CMSBundle\Form\CMSComponentHasColumnType;
use Symfony\Component\HttpFoundation\Response;

/**
 * CMSComponentHasColumn controller.
 *
 * @Route("/extension/column")
 */
class CMSComponentHasColumnController extends Controller
{
    /**
     * Lists all CMSComponentHasColumn entities.
     *
     * @Route("/", name="cmscomponenthascolumn")
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

        $entities = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->getColumnsQB($order, $sequence, $filtr, $sublistId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:CMSComponentHasColumn:_list.html.twig',
            array('entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list" => $list,
            "pagination" => $pagination,
            "response" => true
            );

        return new Response(json_encode($response));
    }

    /**
     * Creates a new CMSComponentHasColumn entity.
     *
     * @Route("/create", name="cmscomponenthascolumn_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $sublistId = (int)$request->get('sublistId');
        $em = $this->getDoctrine()->getManager();

        $entity = new CMSComponentHasColumn();
        $entity->setComponent($em->getRepository('MyCMSBundle:CMSComponent')->find($sublistId));

        $form = $this->createForm(new CMSComponentHasColumnType(), $entity);
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
            $view = $this->renderView('MyCMSBundle:CMSComponentHasColumn:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to create a new CMSComponentHasColumn entity.
     *
     * @Route("/new", name="cmscomponenthascolumn_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $entity = new CMSComponentHasColumn();
        $form = $this->createForm(new CMSComponentHasColumnType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSComponentHasColumn:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
                );

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to edit an existing CMSComponentHasColumn entity.
     *
     * @Route("/{id}/edit", name="cmscomponenthascolumn_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
        }

        $editForm = $this->createForm(new CMSComponentHasColumnType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSComponentHasColumn:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Edits an existing CMSComponentHasColumn entity.
     *
     * @Route("/{id}/update", name="cmscomponenthascolumn_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
        }

        $editForm = $this->createForm(new CMSComponentHasColumnType(), $entity);
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
            $view = $this->renderView('MyCMSBundle:CMSComponentHasColumn:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Deletes a CMSComponentHasColumn entity.
     *
     * @Route("/delete", name="cmscomponenthascolumn_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
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

    /**
     * Change state a CMSComponentHasColumn entity.
     *
     * @Route("/state", name="cmscomponenthascolumn_state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $selectedElement = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($id);

        if (!$selectedElement) {
            throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
        }

        $entities = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')
            ->findByComponent($selectedElement->getComponent());

        foreach ($entities as $entity) {
            if ($entity == $selectedElement) {
                $entity->setIsMainField(true);
            }
            else {
                $entity->setIsMainField(false);
            }

            $em->persist($entity);
        }

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => 'Zmiana domyślnej kolumny zakończyła się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Zmiana domyślnej kolumny zakończyła się niepowodzeniem'
                );
        }

        return new Response(json_encode($response));
    }
}
