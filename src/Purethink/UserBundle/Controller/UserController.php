<?php

namespace Purethink\UserBundle\Controller;

use Purethink\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\UserBundle\Entity\User;
use Purethink\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/user/user")
 */
class UserController extends CRUDController
{
    protected function paramsFilter(array $params)
    {
        if ($params['order'] == 'a.name') {
            $params['order'] = 'a.username';
        }

        return $params;
    }

    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('PurethinkUserBundle:User')
            ->getUsersQB($params['order'], $params['sequence'], $params['filter']);
    }

    protected function getListTemplate()
    {
        return 'PurethinkUserBundle:User:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkUserBundle:User')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('PurethinkUserBundle:User')
            ->getUsersByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new User();
    }

    protected function getForm($entity, $params)
    {
        $class = 'Purethink\UserBundle\Entity\User';

        return $this->createForm(new UserType($class), $entity);
    }

    protected function getNewFormTemplate()
    {
        return 'PurethinkUserBundle:User:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'PurethinkUserBundle:User:_edit.html.twig';
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getEntity($id);
        $entity->setEnabled(!$entity->isEnabled());

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/lock")
     * @Method("POST")
     */
    public function lockAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getEntity($id);
        $entity->setLocked(!$entity->isLocked());

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
