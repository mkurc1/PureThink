<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\ComponentHasColumn;
use My\CMSBundle\Form\ComponentHasColumnType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/extension/column")
 */
class ComponentHasColumnController extends Controller
{
    /**
     * @Route("/")
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

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentHasColumn')
            ->getColumnsQB($order, $sequence, $filtr, $sublistId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:ComponentHasColumn:_list.html.twig',
            array('entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true
            );

        return new Response(json_encode($response));
    }

    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $sublistId = (int)$request->get('sublistId');
        $em = $this->getDoctrine()->getManager();

        $entity = new ComponentHasColumn();
        $entity->setExtension($em->getRepository('MyCMSBundle:Extension')->find($sublistId));

        $form = $this->createForm(new ComponentHasColumnType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Dodawanie kolumny zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:ComponentHasColumn:_new.html.twig',
                array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view"     => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $entity = new ComponentHasColumn();
        $form = $this->createForm(new ComponentHasColumnType(), $entity);

        $view = $this->renderView('MyCMSBundle:ComponentHasColumn:_new.html.twig',
            array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
                );

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:ComponentHasColumn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new ComponentHasColumnType(), $entity);

        $view = $this->renderView('MyCMSBundle:ComponentHasColumn:_edit.html.twig',
            array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:ComponentHasColumn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new ComponentHasColumnType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Edycja kolumny zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:ComponentHasColumn:_edit.html.twig',
                array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view"     => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:ComponentHasColumn')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException();
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
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $selectedElement = $em->getRepository('MyCMSBundle:ComponentHasColumn')->find($id);

        if (!$selectedElement) {
            throw $this->createNotFoundException();
        }

        $entities = $em->getRepository('MyCMSBundle:ComponentHasColumn')
            ->findByExtension($selectedElement->getExtension());

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
                "message"  => 'Zmiana domyślnej kolumny zakończyła się powodzeniem'
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
