<?php

namespace My\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use My\BackendBundle\Entity\Series;

class SeriesController extends Controller
{
    /**
     * @Route("/group/add", name="group_new")
     */
    public function addGroupAction()
    {
        $request = $this->container->get('request');

        $menuId = (int)$request->get('menuId');
        $name = $request->get('name');

        $em = $this->getDoctrine()->getManager();

        $entity = new Series();
        $entity->setName($name);
        $entity->setMenu($em->getRepository('MyBackendBundle:Menu')->find($menuId));

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => "Dodanie grupy zakończyło się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => "Dodanie grupy zakończyło się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/group/edit", name="group_edit")
     */
    public function editGroupAction()
    {
        $request = $this->container->get('request');

        $id = (int)$request->get('id');
        $name = $request->get('name');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyBackendBundle:Series')->find($id);
        $entity->setName($name);

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => "Edycja grupy zakończyła się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => "Edycja grupy zakończyła się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/group/remove", name="group_remove")
     */
    public function removeGroupAction()
    {
        $request = $this->container->get('request');

        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyBackendBundle:Series')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Serires entity.');
        }

        $em->remove($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => "Usuwanie grupy zakończyło się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => "Usuwanie grupy zakończyło się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }
}
