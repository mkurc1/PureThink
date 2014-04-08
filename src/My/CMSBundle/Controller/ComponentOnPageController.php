<?php

namespace My\CMSBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use My\BackendBundle\Controller\CRUDInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\ComponentOnPage;
use My\CMSBundle\Form\ComponentOnPageType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component")
 */
class ComponentOnPageController extends CRUDController implements CRUDInterface
{
    public function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPage')
            ->getComponentsQB($params['order'], $params['sequence'], $params['filter'], $params['languageId'], $params['groupId']);
    }

    public function getListTemplate()
    {
        return 'MyCMSBundle:ComponentOnPage:_list.html.twig';
    }

    public function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPage')
            ->find($id);
    }

    public function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPage')
            ->getComponentsByIds($ids);
    }

    public function getNewEntity($params)
    {
        return new ComponentOnPage();
    }

    public function getForm($entity, $params)
    {
        return $this->createForm(new ComponentOnPageType(), $entity, ['menuId' => $params['menuId']]);
    }

    public function getNewFormTemplate()
    {
        return 'MyCMSBundle:ComponentOnPage:_new.html.twig';
    }

    public function getEditFormTemplate()
    {
        return 'MyCMSBundle:ComponentOnPage:_edit.html.twig';
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

        $response = $this->tryFlush();

        return new Response(json_encode($response));
    }
}
