<?php

namespace My\CMSBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Extension;
use My\CMSBundle\Form\ExtensionType;

/**
 * @Route("/admin/cms/extension")
 */
class ExtensionController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Extension')
            ->getExtensionsQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'MyCMSBundle:Extension:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Extension')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Extension')
            ->getExtensionsByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new Extension();
    }

    protected function getForm($entity, $params)
    {
        return $this->createForm(new ExtensionType(), $entity, ['menuId' => $params['menuId']]);
    }

    protected function getNewFormTemplate()
    {
        return 'MyCMSBundle:Extension:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'MyCMSBundle:Extension:_edit.html.twig';
    }
}
