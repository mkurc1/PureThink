<?php

namespace My\CMSBundle\Controller;

use My\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Menu;
use My\CMSBundle\Form\MenuType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/menu")
 */
class MenuController extends CRUDController
{
    /**
     * @Route("/")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $params = [
            'filter'     => $request->get('filter', null),
            'languageId' => (int)$request->get('languageId'),
            'groupId'    => (int)$request->get('groupId'),
        ];

        $entities = $this->getListQB($params);

        $list = $this->renderView($this->getListTemplate(), compact('entities'));

        $response = [
            "list"       => $list,
            "pagination" => [
                'first_page' => 1,
                'previous'   => 1,
                'next'       => 1,
                'last_page'  => 1,
                'pages'      => [1],
                'hide'       => true
            ],
            "response"   => true
        ];

        return new Response(json_encode($response));
    }

    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Menu')
            ->getMenusQB($params['filter'], $params['languageId'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'MyCMSBundle:Menu:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Menu')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Menu')
            ->getMenusByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new Menu();
    }

    protected function getForm($entity, $params)
    {
        return $this->createForm(new MenuType(), $entity, ['menuId' => $params['menuId']]);
    }

    protected function getNewFormTemplate()
    {
        return 'MyCMSBundle:Menu:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'MyCMSBundle:Menu:_edit.html.twig';
    }

    /**
     * @Route("/sequence")
     * @Method("POST")
     */
    public function sequenceAction(Request $request)
    {
        $sequence = $request->get('sequence');

        $em = $this->getDoctrine()->getManager();

        foreach ($sequence as $value) {
            $entity = $em->getRepository('MyCMSBundle:Menu')->find((int)$value['id']);
            $entity->setSequence((int)$value['sequence']);

            if (isset($value['parentId'])) {
                $entity->setMenu($em->getRepository('MyCMSBundle:Menu')->find((int)$value['parentId']));
            } else {
                $entity->setMenu(null);
            }
        }

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getDoctrine()->getRepository('MyCMSBundle:Menu')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $entity->setIsPublic(!$entity->getIsPublic());

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
