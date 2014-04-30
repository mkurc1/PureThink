<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\Template;
use Purethink\CMSBundle\Form\TemplateType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/template")
 */
class TemplateController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Template')
            ->getTemplatesQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'PurethinkCMSBundle:Template:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Template')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Template')
            ->getTemplatesByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new Template();
    }

    protected function getForm($entity, $params)
    {
        return $this->createForm(new TemplateType(), $entity, ['menuId' => $params['menuId']]);
    }

    protected function getNewFormTemplate()
    {
        return 'PurethinkCMSBundle:Template:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'PurethinkCMSBundle:Template:_edit.html.twig';
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
