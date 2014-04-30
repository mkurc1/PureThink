<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\Component;
use Purethink\CMSBundle\Form\ComponentType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component")
 */
class ComponentController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Component')
            ->getComponentsQB($params['order'], $params['sequence'], $params['filter'], $params['languageId'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'PurethinkCMSBundle:Component:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Component')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Component')
            ->getComponentsByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new Component();
    }

    protected function getForm($entity, $params)
    {
        return $this->createForm(new ComponentType(), $entity, ['menuId' => $params['menuId']]);
    }

    protected function getNewFormTemplate()
    {
        return 'PurethinkCMSBundle:Component:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'PurethinkCMSBundle:Component:_edit.html.twig';
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getEntity($id);
        $entity->setIsEnable(!$entity->getIsEnable());

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
