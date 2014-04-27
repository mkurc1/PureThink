<?php

namespace My\CMSBundle\Controller;

use My\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Component;
use My\CMSBundle\Form\ComponentType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component")
 */
class ComponentController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Component')
            ->getComponentsQB($params['order'], $params['sequence'], $params['filter'], $params['languageId'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'MyCMSBundle:Component:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Component')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Component')
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
        return 'MyCMSBundle:Component:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'MyCMSBundle:Component:_edit.html.twig';
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

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
