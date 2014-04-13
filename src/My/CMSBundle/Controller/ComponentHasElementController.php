<?php

namespace My\CMSBundle\Controller;

use My\CMSBundle\Entity\ComponentHasArticle;
use My\CMSBundle\Entity\ComponentHasFile;
use My\CMSBundle\Entity\ComponentHasText;
use My\CMSBundle\Entity\ExtensionHasField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\ComponentHasElement;
use My\CMSBundle\Entity\ComponentHasValue;
use My\CMSBundle\Form\ComponentHasElementType;
use My\CMSBundle\Form\ComponentHasValueType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component/element")
 */
class ComponentHasElementController extends Controller
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
            $order = 'cc.content';
        }

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentHasElement')
            ->getElementsQB($order, $sequence, $filter, $sublistId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:ComponentHasElement:_list.html.twig',
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

        $entity = new ComponentHasElement();
        $entity->setComponent($em->getRepository('MyCMSBundle:Component')->find($sublistId));

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);

        if ($form->submit($request) && $form->isValid()) {
            $em->persist($entity);

            $response = $this->get('my.flush.service')->tryFlush();
            $response['id'] = $entity->getId();
        } else {
            $view = $this->renderView('MyCMSBundle:ComponentHasElement:_new.html.twig',
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

        $entity = new ComponentHasElement();

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId);

        $view = $this->renderView('MyCMSBundle:ComponentHasElement:_new.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
        ];

        return new Response(json_encode($response));
    }

    private function getColumns(ComponentHasElement $entity, $componentId, $editedEntityId = false)
    {
        $em = $this->getDoctrine()->getManager();

        $component = $em->getRepository('MyCMSBundle:Component')->find($componentId);
        $columns = $em->getRepository('MyCMSBundle:ExtensionHasField')
            ->findByExtension($component->getExtension());

        foreach ($columns as $column) {
            switch ($column->getTypeOfField()) {
                case ExtensionHasField::TYPE_ARTICLE:
                    $componentHasValue = new ComponentHasArticle($entity, $column);
                    break;
                case ExtensionHasField::TYPE_FILE:
                    $componentHasValue = new ComponentHasFile($entity, $column);
                    break;
                default:
                    $componentHasValue = new ComponentHasText($entity, $column);
            }

            if ($editedEntityId) {
                $contentEntity = $em->getRepository('MyCMSBundle:ComponentHasValue')
                    ->getContent($editedEntityId, $column->getId());

                $componentHasValue->setContent($contentEntity->getContent());
            }

            $entity->addComponentHasValue($componentHasValue);
        }

        return $entity;
    }

    private function addColumns($form, ComponentHasElement $entity, $componentId, $editedEntityId = false)
    {
        $columns = $this->getColumns($entity, $componentId, $editedEntityId);
        foreach ($columns->getComponentHasValues() as $key => $column) {
            $form->get('componentHasValues')->add('column_' . $key, new ComponentHasValueType($column));
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

        $entity = new ComponentHasElement();

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId, $id);

        $entity = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentHasElement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $view = $this->renderView('MyCMSBundle:ComponentHasElement:_edit.html.twig', ['entity' => $entity, 'form' => $form->createView()]);

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

        $entity = new ComponentHasElement();

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity, $sublistId, $id);

        $entity = $em->getRepository('MyCMSBundle:ComponentHasElement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        if ($form->submit($request) && $form->isValid()) {
            $columns = $form->get('componentHasValues');
            $columnsValue = $em->getRepository('MyCMSBundle:ComponentHasValue')->findByComponentHasElement($entity);

            foreach ($columnsValue as $key => $columnValue) {
                $columnValue->setContent($columns['column_' . $key]->get('content')->getData());
                $em->persist($columnValue);
            }

            $em->persist($entity);

            $response = $this->get('my.flush.service')->tryFlush();
            $response['id'] = $entity->getId();
        } else {
            $view = $this->renderView('MyCMSBundle:ComponentHasElement:_edit.html.twig',
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
            $entity = $em->getRepository('MyCMSBundle:ComponentHasElement')->find((int)$id);
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

        $entity = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentHasElement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $entity->setIsEnable(!$entity->getIsEnable());

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
