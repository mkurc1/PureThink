<?php

namespace Purethink\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Purethink\AdminBundle\Entity\Series;

class SeriesController extends Controller
{
    /**
     * @Route("/group/add", name="group_new")
     * @Method("POST")
     */
    public function addGroupAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');
        $name = $request->get('name');

        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('PurethinkAdminBundle:Menu')->find($menuId);
        $entity = new Series($name, $menu);

        $em->persist($entity);

        $response = $this->get('purethink.flush.service')->tryFlush();
        $response['id'] = $entity->getId();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/group/edit", name="group_edit")
     * @Method("POST")
     */
    public function editGroupAction(Request $request)
    {
        $id = (int)$request->get('id');
        $name = $request->get('name');

        $entity = $this->getDoctrine()->getRepository('PurethinkAdminBundle:Series')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $entity->setName($name);

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/group/remove", name="group_remove")
     * @Method("POST")
     */
    public function removeGroupAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PurethinkAdminBundle:Series')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $em->remove($entity);

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
