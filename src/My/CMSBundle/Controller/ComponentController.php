<?php

namespace My\CMSBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use My\BackendBundle\Controller\CRUDInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Component;
use My\CMSBundle\Form\ComponentType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component")
 */
class ComponentController extends CRUDController implements CRUDInterface
{
    public function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Component')
            ->getComponentsQB($params['order'], $params['sequence'], $params['filter'], $params['languageId'], $params['groupId']);
    }

    public function getListTemplate()
    {
        return 'MyCMSBundle:Component:_list.html.twig';
    }

    public function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Component')
            ->find($id);
    }

    public function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Component')
            ->getComponentsByIds($ids);
    }

    public function getNewEntity($params)
    {
        return new Component();
    }

    public function getForm($entity, $params)
    {
        return $this->createForm(new ComponentType(), $entity, ['menuId' => $params['menuId']]);
    }

    public function getNewFormTemplate()
    {
        return 'MyCMSBundle:Component:_new.html.twig';
    }

    public function getEditFormTemplate()
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
