<?php

namespace My\CMSBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use My\BackendBundle\Controller\CRUDInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Extension;
use My\CMSBundle\Form\ExtensionType;

/**
 * @Route("/admin/cms/extension")
 */
class ExtensionController extends CRUDController implements CRUDInterface
{
    public function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Extension')
            ->getExtensionsQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
    }

    public function getListTemplate()
    {
        return 'MyCMSBundle:Extension:_list.html.twig';
    }

    public function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Extension')
            ->find($id);
    }

    public function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Extension')
            ->getExtensionsByIds($ids);
    }

    public function getNewEntity($params)
    {
        return new Extension();
    }

    public function getForm($entity, $params)
    {
        return $this->createForm(new ExtensionType(), $entity, ['menuId' => $params['menuId']]);
    }

    public function getNewFormTemplate()
    {
        return 'MyCMSBundle:Extension:_new.html.twig';
    }

    public function getEditFormTemplate()
    {
        return 'MyCMSBundle:Extension:_edit.html.twig';
    }
}
