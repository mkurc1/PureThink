<?php

namespace My\CMSBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use My\BackendBundle\Controller\CRUDInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Component;
use My\CMSBundle\Form\ComponentType;

/**
 * @Route("/admin/cms/extension")
 */
class ComponentController extends CRUDController implements CRUDInterface
{
    public function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Component')
            ->getComponentsQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
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

    public function getNewEntity()
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
}
