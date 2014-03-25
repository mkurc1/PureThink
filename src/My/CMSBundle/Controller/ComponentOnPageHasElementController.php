<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $page       = (int)$request->get('page', 1);
        $order      = $request->get('order', 'a.name');
        $sequence   = $request->get('sequence', 'ASC');
        $filtr      = $request->get('filtr');
        $sublistId  = (int)$request->get('sublistId');

        if ($order == 'a.name') {
            $order = 'a.content';
        }

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPageHasValue')
            ->getElementsQB($order, $sequence, $filtr, $sublistId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_list.html.twig',
            array('entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true,
            "order"      => $order
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

        $entity = new ComponentOnPageHasElement();
        $entity->setComponentOnPage($em->getRepository('MyCMSBundle:ComponentOnPage')->find($sublistId));

        $form = $this->createForm(new ComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Dodawanie kolumny zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

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
        $sublistId = (int)$request->get('sublistId');

        $entity = new ComponentOnPageHasElement();

        $form = $this->createForm(new ComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);

        $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
            "response" => true,
            "view"     => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Get columns
     *
     * @param ComponentOnPageHasElement $entity
     * @param integer $CMSComponentOnPageId
     * @param integer $editedEntityId
     * @return CMSComponentOnPageHasElement
     */
    private function getColumns(ComponentOnPageHasElement $entity, $ComponentOnPageId, $editedEntityId = false)
    {
        $em = $this->getDoctrine()->getManager();

        $ComponentOnPage = $em->getRepository('MyCMSBundle:ComponentOnPage')->find($ComponentOnPageId);
        $columns = $em->getRepository('MyCMSBundle:ComponentHasColumn')
            ->findByComponent($ComponentOnPage->getComponent());

        foreach ($columns as $column) {
            $ComponentOnPageHasValue = new ComponentOnPageHasValue();
            $ComponentOnPageHasValue->setComponentOnPageHasElement($entity);
            $ComponentOnPageHasValue->setComponentHasColumn($column);

            if ($editedEntityId) {
                $contentEntity = $em->getRepository('MyCMSBundle:ComponentOnPageHasValue')->getContent($editedEntityId, $column->getId());

                $ComponentOnPageHasValue->setContent($contentEntity->getContent());
            }

            $entity->addComponentOnPageHasValue($ComponentOnPageHasValue);
        }

        return $entity;
    }

    /**
     * Add columns
     *
     * @param object $form
     * @param CMSComponentOnPageHasElement $entity
     * @param integer $CMSComponentOnPageId
     * @param integer $editedEntityId
     * @return CMSComponentOnPageHasElementType
     */
    private function addColumns($form, ComponentOnPageHasElement $entity, $ComponentOnPageId, $editedEntityId = false)
    {
        $columns = $this->getColumns($entity, $ComponentOnPageId, $editedEntityId);
        foreach ($columns->getComponentOnPageHasValues() as $key => $column) {
            $class = $column->getComponentHasColumn()->getClass();
            if ($column->getComponentHasColumn()->getIsMainField()) {
                $class .= " name";
            }

            $form->get('componentOnPageHasValues')->add('column_'.$key, new ComponentOnPageHasValueType($column), array(
                'attr' => array(
                    'class'      => $class,
                    'type'       => $column->getComponentHasColumn()->getColumnTypeString(),
                    'label'      => $column->getComponentHasColumn()->getColumnLabel(),
                    'isRequired' => $column->getComponentHasColumn()->getIsRequired()
                    )
                )
            );
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

        $em = $this->getDoctrine()->getManager();

        $entity = new ComponentOnPageHasElement();

        $form = $this->createForm(new ComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId, $id);

        $entity = $em->getRepository('MyCMSBundle:ComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_edit.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
            "response" => true,
            "view"     => $view
            );

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

        $form->bind($request);

        if ($form->isValid()) {
            $columns = $form->get('componentOnPageHasValues');
            $columnsValue = $em->getRepository('MyCMSBundle:ComponentOnPageHasValue')->findByComponentOnPageHasElement($entity);

            foreach ($columnsValue as $key => $columnValue) {
                $columnValue->setContent($columns['column_'.$key]->get('content')->getData());
                $em->persist($columnValue);
            }

            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message" => 'Edycja kolumny zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:ComponentOnPageHasElement:_edit.html.twig', array('entity' => $entity, 'form' => $form->createView()));

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

        $entity = $em->getRepository('MyCMSBundle:ComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        if ($entity->getIsEnable()) {
            $entity->setIsEnable(false);
        }
        else {
            $entity->setIsEnable(true);
        }

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => 'Zmiana stanu zakończyła się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Zmiana stanu zakończyła się niepowodzeniem'
                );
        }

        return new Response(json_encode($response));
    }
}
