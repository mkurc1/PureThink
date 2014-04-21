<?php

namespace My\UserBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\UserBundle\Entity\User;
use My\UserBundle\Form\UserType;
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
        return $this->getDoctrine()->getRepository('MyUserBundle:User')
            ->getUsersQB($params['order'], $params['sequence'], $params['filter']);
    }

    protected function getListTemplate()
    {
        return 'MyUserBundle:User:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyUserBundle:User')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyUserBundle:User')
            ->getUsersByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new User();
    }

    protected function getForm($entity, $params)
    {
        $class = 'My\UserBundle\Entity\User';

        return $this->createForm(new UserType($class), $entity);
    }

    protected function getNewFormTemplate()
    {
        return 'MyUserBundle:User:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'MyUserBundle:User:_edit.html.twig';
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

        $response = $this->get('my.flush.service')->tryFlush();

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

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
