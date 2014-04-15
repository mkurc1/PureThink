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
            $order = 'c.content';
        }

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentHasText')
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

        $entity = new ComponentHasElement($this->getComponent($sublistId));

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity);

        if ($form->submit($request) && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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

        $entity = new ComponentHasElement($this->getComponent($sublistId));

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity);

        $view = $this->renderView('MyCMSBundle:ComponentHasElement:_new.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
        ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $entity = $this->getComponentHasElement($id);

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity);

        $view = $this->renderView('MyCMSBundle:ComponentHasElement:_edit.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

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
        $entity = $this->getComponentHasElement($id);

        $form = $this->createForm(new ComponentHasElementType($entity));
        $form = $this->addColumns($form, $entity);

        if ($form->submit($request) && $form->isValid()) {
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

    private function getComponentHasElement($id)
    {
        $componentHasElement = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentHasElement')->find($id);
        if (null == $componentHasElement) {
            throw $this->createNotFoundException();
        }

        return $componentHasElement;
    }

    private function getComponent($id)
    {
        $component = $this->getDoctrine()->getRepository('MyCMSBundle:Component')->find($id);

        if (null == $component) {
            throw $this->createNotFoundException();
        }

        return $component;
    }

    private function getComponentHasValueType(ComponentHasElement $entity, ExtensionHasField $field)
    {
        switch ($field->getTypeOfField()) {
            case ExtensionHasField::TYPE_ARTICLE:
                return new ComponentHasArticle($entity, $field);
                break;
            case ExtensionHasField::TYPE_FILE:
                return new ComponentHasFile($entity, $field);
                break;
            default:
                return new ComponentHasText($entity, $field);
        }
    }

    private function getColumns(ComponentHasElement $componentHasElement)
    {
        $fields = $componentHasElement->getComponent()->getExtension()->getFields();
        foreach ($fields as $field) {
            $componentHasValue = $this->getComponentHasValueType($componentHasElement, $field);

            $componentHasElement->addComponentHasValue($componentHasValue);
        }

        return $componentHasElement;
    }

    private function addColumns($form, ComponentHasElement $componentHasElement)
    {
        if ($componentHasElement->getComponentHasValues()->count() == 0) {
            $componentHasElement = $this->getColumns($componentHasElement);
        }

        foreach ($componentHasElement->getComponentHasValues() as $key => $componentHasValue) {
            $form->get('componentHasValues')->add('column_' . $key, new ComponentHasValueType($componentHasValue));
        }

        return $form;
    }
}
