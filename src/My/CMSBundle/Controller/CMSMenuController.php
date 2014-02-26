<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSMenu;
use My\CMSBundle\Form\CMSMenuType;
use Symfony\Component\HttpFoundation\Response;

use My\BackendBundle\Pagination\Pagination as Pagination;

/**
 * CMSMenu controller.
 *
 * @Route("/menu")
 */
class CMSMenuController extends Controller
{
    /**
     * Lists all CMSMenu entities.
     *
     * @Route("/", name="cmsmenu")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $filtr      = $request->get('filtr');
        $languageId = (int)$request->get('languageId');
        $groupId    = (int)$request->get('groupId');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSMenu')->getMenusQB($filtr, $languageId, $groupId);

        $list = $this->renderView('MyCMSBundle:CMSMenu:_list.html.twig', array('entities' => $entities));

        $response = array(
            "list" => $list,
            "pagination" => array(
                'first_page' => 1,
                'previous' => 1,
                'next' => 1,
                'last_page' => 1,
                'pages' => array(1),
                'hide' => true
                ),
            "response" => true
            );

        return new Response(json_encode($response));
    }

    /**
     * Creates a new CMSMenu entity.
     *
     * @Route("/create", name="cmsmenu_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new CMSMenu();

        $form = $this->createForm(new CMSMenuType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Dodawanie menu zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSMenu:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to create a new CMSMenu entity.
     *
     * @Route("/new", name="cmsmenu_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new CMSMenu();
        $form = $this->createForm(new CMSMenuType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:CMSMenu:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
                );

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to edit an existing CMSMenu entity.
     *
     * @Route("/{id}/edit", name="cmsmenu_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSArticle entity.');
        }

        $editForm = $this->createForm(new CMSMenuType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:CMSMenu:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Edits an existing CMSMenu entity.
     *
     * @Route("/{id}/update", name="cmsmenu_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSMenu entity.');
        }

        $editForm = $this->createForm(new CMSMenuType(), $entity, array('attr' => array(
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
            $view = $this->renderView('MyCMSBundle:CMSMenu:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Deletes a CMSMenu entity.
     *
     * @Route("/delete", name="cmsmenu_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:CMSMenu')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSMenu entity.');
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
     * Change sequence a CMSMenu entity.
     *
     * @Route("/sequence", name="cmsmenu_sequence")
     * @Method("POST")
     */
    public function sequenceAction(Request $request)
    {
        $sequence = $request->get('sequence');

        $em = $this->getDoctrine()->getManager();

        foreach ($sequence as $key => $value) {
            $entity = $em->getRepository('MyCMSBundle:CMSMenu')->find((int)$value['id']);
            $entity->setSequence((int)$value['sequence']);

            if (isset($value['parentId'])) {
                $entity->setMenu($em->getRepository('MyCMSBundle:CMSMenu')->find((int)$value['parentId']));
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
     * Change state a CMSMenu entity.
     *
     * @Route("/state", name="cmsmenu_state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSMenu entity.');
        }

        if ($entity->getIsPublic()) {
            $entity->setIsPublic(false);
        }
        else {
            $entity->setIsPublic(true);
        }

        $em->persist($entity);

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
