<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\AdminBundle\Controller\CRUDController;
use Purethink\CMSBundle\Entity\ComponentHasArticle;
use Purethink\CMSBundle\Entity\ComponentHasFile;
use Purethink\CMSBundle\Entity\ComponentHasText;
use Purethink\CMSBundle\Entity\ExtensionHasField;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\ComponentHasElement;
use Purethink\CMSBundle\Form\ComponentHasElementType;
use Purethink\CMSBundle\Form\ComponentHasValueType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component/element")
 */
class ComponentHasElementController extends CRUDController
{
    protected function paramsFilter(array $params)
    {
        if ($params['order'] == 'a.name') {
            $params['order'] = 'c.text';
        }

        return $params;
    }

    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:ComponentHasText')
            ->getElementsQB($params['order'], $params['sequence'], $params['filter'], $params['sublistId']);
    }

    protected function getListTemplate()
    {
        return 'PurethinkCMSBundle:ComponentHasElement:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:ComponentHasElement')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:ComponentHasElement')
            ->getElementsByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new ComponentHasElement($this->getComponent($params['sublistId']));
    }

    protected function getForm($entity, $params)
    {
        $form = $this->createForm(new ComponentHasElementType($entity));

        return $this->addColumns($form, $entity);
    }

    protected function getNewFormTemplate()
    {
        return 'PurethinkCMSBundle:ComponentHasElement:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'PurethinkCMSBundle:ComponentHasElement:_edit.html.twig';
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getEntityById($id);
        $entity->setIsEnable(!$entity->getIsEnable());

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    private function getComponent($id)
    {
        $component = $this->getDoctrine()->getRepository('PurethinkCMSBundle:Component')->find($id);

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
