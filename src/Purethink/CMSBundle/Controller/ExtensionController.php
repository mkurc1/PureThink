<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\AdminBundle\Controller\CRUDController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\Extension;
use Purethink\CMSBundle\Form\ExtensionType;

/**
 * @Route("/admin/cms/extension")
 */
class ExtensionController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Extension')
            ->getExtensionsQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'PurethinkCMSBundle:Extension:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Extension')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Extension')
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
        return 'PurethinkCMSBundle:Extension:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'PurethinkCMSBundle:Extension:_edit.html.twig';
    }
}
