<?php

namespace My\CMSBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Template;
use My\CMSBundle\Form\TemplateType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/template")
 */
class TemplateController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Template')
            ->getTemplatesQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'MyCMSBundle:Template:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Template')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Template')
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
        return 'MyCMSBundle:Template:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'MyCMSBundle:Template:_edit.html.twig';
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
