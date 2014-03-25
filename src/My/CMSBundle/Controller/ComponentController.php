<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\Component;
use My\CMSBundle\Form\ComponentType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/extension")
 */
class ComponentController extends Controller
{
    /**
     * @Route("/")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page       = (int)$request->get('page', 1);
        $order      = $request->get('order', 'a.name');
        $sequence   = $request->get('sequence', 'ASC');
        $filtr      = $request->get('filtr');
        $groupId    = (int)$request->get('groupId');

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:Component')
            ->getComponentsQB($order, $sequence, $filtr, $groupId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:Component:_list.html.twig',
            array('entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true
            );

        return new Response(json_encode($response));
    }

    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new Component();

        $form = $this->createForm(new ComponentType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Dodawanie rozszerzenia zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:Component:_new.html.twig',
                array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view"     => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new Component();
        $form = $this->createForm(new ComponentType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:Component:_new.html.twig',
            array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
            "response" => true,
            "view"     => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:Component')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new ComponentType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:Component:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view"     => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:Component')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new ComponentType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Edycja rozszerzenia zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:Component:_edit.html.twig',
                array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view"     => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:Component')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException();
            }

            $em->remove($entity);
        }

        try {
            $em->flush();

            if (count($arrayId) > 1) {
                $message = 'Usuwanie rozszerzeń zakończyło się powodzeniem';
            }
            else {
                $message = 'Usuwanie rozszerzenia zakończyło się powodzeniem';
            }

            $response = array(
                "response" => true,
                "message"  => $message
                );
        } catch (\Exception $e) {
            if (count($arrayId) > 1) {
                $message = 'Usuwanie rozszerzeń zakończyło się niepowodzeniem';
            }
            else {
                $message = 'Usuwanie rozszerzenia zakończyło się niepowodzeniem';
            }

            $response = array(
                "response" => false,
                "message"  => $message
                );
        }

        return new Response(json_encode($response));
    }
}
