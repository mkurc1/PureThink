<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentOnPageHasElement;
use My\CMSBundle\Entity\CMSComponentOnPageHasValue;
use My\CMSBundle\Form\CMSComponentOnPageHasElementType;
use My\CMSBundle\Form\CMSComponentOnPageHasValueType;
use Symfony\Component\HttpFoundation\Response;

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

        if ($order == 'a.name') {
            $order = 'a.content';
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->getElementsQB($order, $sequence, $filtr, $sublistId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_list.html.twig',
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

        $form = $this->createForm(new CMSComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);
        $form->bind($request);

        if ($form->isValid()) {
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
        $sublistId = (int)$request->get('sublistId');

        $entity = new CMSComponentOnPageHasElement();

        $form = $this->createForm(new CMSComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);

        $view = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Get columns
     *
     * @param CMSComponentOnPageHasElement $entity
     * @param integer $CMSComponentOnPageId
     * @param integer $editedEntityId
     * @return CMSComponentOnPageHasElement
     */
    private function getColumns(CMSComponentOnPageHasElement $entity, $CMSComponentOnPageId, $editedEntityId = false)
    {
        $em = $this->getDoctrine()->getManager();

        $CMSComponentOnPage = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($CMSComponentOnPageId);
        $columns = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')
            ->findByComponent($CMSComponentOnPage->getComponent());

        foreach ($columns as $column) {
            $CMSComponentOnPageHasValue = new CMSComponentOnPageHasValue();
            $CMSComponentOnPageHasValue->setComponentOnPageHasElement($entity);
            $CMSComponentOnPageHasValue->setComponentHasColumn($column);

            if ($editedEntityId) {
                $contentEntity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->getContent($editedEntityId, $column->getId());

                $CMSComponentOnPageHasValue->setContent($contentEntity->getContent());
            }

            $entity->addComponentOnPageHasValue($CMSComponentOnPageHasValue);
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
    private function addColumns($form, CMSComponentOnPageHasElement $entity, $CMSComponentOnPageId, $editedEntityId = false)
    {
        $columns = $this->getColumns($entity, $CMSComponentOnPageId, $editedEntityId);
        foreach ($columns->getComponentOnPageHasValues() as $key => $column) {
            $class = $column->getComponentHasColumn()->getClass();
            if ($column->getComponentHasColumn()->getIsMainField()) {
                $class .= " name";
            }

            $form->get('componentOnPageHasValues')->add('column_'.$key, new CMSComponentOnPageHasValueType($column), array(
                'attr' => array(
                    'class' => $class,
                    'type' => $column->getComponentHasColumn()->getColumnType()->getName(),
                    'label' => $column->getComponentHasColumn()->getColumnLabel(),
                    'isRequired' => $column->getComponentHasColumn()->getIsRequired()
                    )
                )
            );
        }

        return $form;
    }

    /**
     * Displays a form to edit an existing CMSComponentOnPageHasElement entity.
     *
     * @Route("/{id}/edit", name="cmscomponentonpagehaselement_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $sublistId = (int)$request->get('sublistId');

        $em = $this->getDoctrine()->getManager();

        $entity = new CMSComponentOnPageHasElement();

        $form = $this->createForm(new CMSComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId, $id);

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
        }

        $view = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_edit.html.twig', array('entity' => $entity, 'form' => $form->createView()));

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
        $sublistId = (int)$request->get('sublistId');

        $em = $this->getDoctrine()->getManager();

        $entity = new CMSComponentOnPageHasElement();

        $form = $this->createForm(new CMSComponentOnPageHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId, $id);

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
        }

        $form->bind($request);

        if ($form->isValid()) {
            $columns = $form->get('componentOnPageHasValues');
            $columnsValue = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->findByComponentOnPageHasElement($entity);

            foreach ($columnsValue as $key => $columnValue) {
                $columnValue->setContent($columns['column_'.$key]->get('content')->getData());
                $em->persist($columnValue);
            }

            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Edycja kolumny zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSComponentOnPageHasElement:_edit.html.twig', array('entity' => $entity, 'form' => $form->createView()));

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

    /**
     * Change state a CMSComponentOnPageHasElement entity.
     *
     * @Route("/state", name="cmscomponentonpagehaselement_state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
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
