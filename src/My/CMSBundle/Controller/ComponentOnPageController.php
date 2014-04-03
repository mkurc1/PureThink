<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\ComponentOnPage;
use My\CMSBundle\Form\ComponentOnPageType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/component")
 */
class ComponentOnPageController extends Controller
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
        $filter     = $request->get('filtr');
        $languageId = (int)$request->get('languageId');
        $groupId    = (int)$request->get('groupId');

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPage')
            ->getComponentsQB($order, $sequence, $filter, $languageId, $groupId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:ComponentOnPage:_list.html.twig',
        ['entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage]);

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

        $entity = new ComponentOnPage;

        $form = $this->createForm(new ComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Dodawanie komponentu zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:ComponentOnPage:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

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

        $entity = new ComponentOnPage();
        $form = $this->createForm(new ComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:ComponentOnPage:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
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

        $entity = $em->getRepository('MyCMSBundle:ComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new ComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:ComponentOnPage:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
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

        $entity = $em->getRepository('MyCMSBundle:ComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new ComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Edycja komponentu zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:ComponentOnPage:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
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
            $entity = $em->getRepository('MyCMSBundle:ComponentOnPage')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException();
            }

            $em->remove($entity);
        }

        try {
            $em->flush();

            if (count($arrayId) > 1) {
                $message = 'Usuwanie komponentów zakończyło się powodzeniem';
            }
            else {
                $message = 'Usuwanie komponentu zakończyło się powodzeniem';
            }

            $response = array(
                "response" => true,
                "message" => $message
                );
        } catch (\Exception $e) {
            if (count($arrayId) > 1) {
                $message = 'Usuwanie komponentów zakończyło się niepowodzeniem';
            }
            else {
                $message = 'Usuwanie komponentu zakończyło się niepowodzeniem';
            }

            $response = array(
                "response" => false,
                "message" => $message
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:ComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        if ($entity->getIsEnable()) {
            $entity->setIsEnable(false);
        }
        else {
            $entity->setIsEnable(true);
        }

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => 'Zmiana stanu komponentu zakończyła się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Zmiana stanu komponentu zakończyła się niepowodzeniem'
                );
        }

        return new Response(json_encode($response));
    }
}
