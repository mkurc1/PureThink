<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\Menu;
use My\CMSBundle\Form\MenuType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/menu")
 */
class MenuController extends Controller
{
    /**
     * @Route("/")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $filtr      = $request->get('filtr');
        $languageId = (int)$request->get('languageId');
        $groupId    = (int)$request->get('groupId');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:Menu')->getMenusQB($filtr, $languageId, $groupId);

        $list = $this->renderView('MyCMSBundle:Menu:_list.html.twig', array('entities' => $entities));

        $response = array(
            "list" => $list,
            "pagination" => array(
                'first_page' => 1,
                'previous'   => 1,
                'next'       => 1,
                'last_page'  => 1,
                'pages'      => array(1),
                'hide'       => true
                ),
            "response" => true
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

        $entity = new Menu();

        $form = $this->createForm(new MenuType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Dodawanie menu zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:Menu:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

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

        $entity = new Menu();
        $form = $this->createForm(new MenuType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:Menu:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

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

        $entity = $em->getRepository('MyCMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new MenuType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:Menu:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

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

        $entity = $em->getRepository('MyCMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new MenuType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Edycja menu zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:Menu:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

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
            $entity = $em->getRepository('MyCMSBundle:Menu')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException();
            }

            $em->remove($entity);
        }

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => 'Usuwanie menu zakończyło się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Usuwanie menu zakończyło się niepowodzeniem'
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/sequence")
     * @Method("POST")
     */
    public function sequenceAction(Request $request)
    {
        $sequence = $request->get('sequence');

        $em = $this->getDoctrine()->getManager();

        foreach ($sequence as $key => $value) {
            $entity = $em->getRepository('MyCMSBundle:Menu')->find((int)$value['id']);
            $entity->setSequence((int)$value['sequence']);

            if (isset($value['parentId'])) {
                $entity->setMenu($em->getRepository('MyCMSBundle:Menu')->find((int)$value['parentId']));
            }
            else {
                $entity->setMenu(null);
            }

            $em->persist($entity);
        }

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => 'Zmiana kolejności zakończyła się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Zmiana kolejności zakończyła się niepowodzeniem'
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

        $entity = $em->getRepository('MyCMSBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $entity->setIsPublic(!$entity->getIsPublic());

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => 'Zmiana stanu menu zakończyło się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Zmiana stanu menu zakończyło się niepowodzeniem'
                );
        }

        return new Response(json_encode($response));
    }
}
