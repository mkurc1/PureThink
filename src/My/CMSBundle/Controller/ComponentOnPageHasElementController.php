<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\ComponentOnPageHasElement;
use My\CMSBundle\Entity\ComponentOnPageHasValue;
use My\CMSBundle\Form\ComponentOnPageHasElementType;
use My\CMSBundle\Form\ComponentOnPageHasValueType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component/element")
 */
class ComponentOnPageHasElementController extends Controller
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
        $filter = $request->get('filtr');
        $sublistId = (int)$request->get('sublistId');

        if ($order == 'a.name') {
            $order = 'a.content';
        }

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPageHasValue')
            ->getElementsQB($order, $sequence, $filter, $sublistId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_list.html.twig',
            ['entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage]);

        $response = [
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true,
            "order"      => $order
        ];

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

        $entity = new ComponentOnPageHasElement();
        $entity->setComponent($em->getRepository('MyCMSBundle:Component')->find($sublistId));

        $form = $this->createForm(new ComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);

        if ($form->submit($request) && $form->isValid()) {
            $em->persist($entity);

            $response = $this->get('my.flush.service')->tryFlush();
            $response['id'] = $entity->getId();
        } else {
            $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_new.html.twig',
                ['entity' => $entity, 'form' => $form->createView()]);

            $response = [
                "response" => false,
                "view"     => $view
            ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $sublistId = (int)$request->get('sublistId');

        $entity = new ComponentOnPageHasElement();

        $form = $this->createForm(new ComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);

        $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_new.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
        ];

        return new Response(json_encode($response));
    }

    private function getColumns(ComponentOnPageHasElement $entity, $ComponentId, $editedEntityId = false)
    {
        $em = $this->getDoctrine()->getManager();

        $Component = $em->getRepository('MyCMSBundle:Component')->find($ComponentId);
        $columns = $em->getRepository('MyCMSBundle:ExtensionHasField')
            ->findByExtension($Component->getExtension());

        foreach ($columns as $column) {
            $ComponentOnPageHasValue = new ComponentOnPageHasValue($entity, $column);

            if ($editedEntityId) {
                $contentEntity = $em->getRepository('MyCMSBundle:ComponentOnPageHasValue')->getContent($editedEntityId, $column->getId());

                $ComponentOnPageHasValue->setContent($contentEntity->getContent());
            }

            $entity->addComponentOnPageHasValue($ComponentOnPageHasValue);
        }

        return $entity;
    }

    private function addColumns($form, ComponentOnPageHasElement $entity, $ComponentId, $editedEntityId = false)
    {
        $columns = $this->getColumns($entity, $ComponentId, $editedEntityId);
        foreach ($columns->getComponentOnPageHasValues() as $key => $column) {
            $form->get('componentOnPageHasValues')->add('column_' . $key, new ComponentOnPageHasValueType($column));
        }

        return $form;
    }

    /**
     * @Route("/{id}/edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $sublistId = (int)$request->get('sublistId');

        $entity = new ComponentOnPageHasElement();

        $form = $this->createForm(new ComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId, $id);

        $entity = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPageHasElement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_edit.html.twig', ['entity' => $entity, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
        ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $sublistId = (int)$request->get('sublistId');

        $em = $this->getDoctrine()->getManager();

        $entity = new ComponentOnPageHasElement();

        $form = $this->createForm(new ComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId, $id);

        $entity = $em->getRepository('MyCMSBundle:ComponentOnPageHasElement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        if ($form->submit($request) && $form->isValid()) {
            $columns = $form->get('componentOnPageHasValues');
            $columnsValue = $em->getRepository('MyCMSBundle:ComponentOnPageHasValue')->findByComponentOnPageHasElement($entity);

            foreach ($columnsValue as $key => $columnValue) {
                $columnValue->setContent($columns['column_' . $key]->get('content')->getData());
                $em->persist($columnValue);
            }

            $em->persist($entity);

            $response = $this->get('my.flush.service')->tryFlush();
            $response['id'] = $entity->getId();
        } else {
            $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_edit.html.twig',
                ['entity' => $entity, 'form' => $form->createView()]);

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
            $entity = $em->getRepository('MyCMSBundle:ComponentOnPageHasElement')->find((int)$id);
            if (!$entity) {
                throw $this->createNotFoundException();
            }

            $em->remove($entity);
        }

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPageHasElement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $entity->setIsEnable(!$entity->getIsEnable());

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
