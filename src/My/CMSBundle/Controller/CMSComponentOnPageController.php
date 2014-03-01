<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentOnPage;
use My\CMSBundle\Form\CMSComponentOnPageType;
use Symfony\Component\HttpFoundation\Response;

/**
 * CMSComponentOnPage controller.
 *
 * @Route("/admin/cms/component")
 */
class CMSComponentOnPageController extends Controller
{
    /**
     * Lists all CMSComponentOnPage entities.
     *
     * @Route("/", name="cmscomponentonpage")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page       = (int)$request->get('page', 1);
        $order      = $request->get('order', 'a.name');
        $sequence   = $request->get('sequence', 'ASC');
        $filtr      = $request->get('filtr');
        $languageId = (int)$request->get('languageId');
        $groupId    = (int)$request->get('groupId');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->getComponentsQB($order, $sequence, $filtr, $languageId, $groupId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:CMSComponentOnPage:_list.html.twig',
            array('entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list" => $list,
            "pagination" => $pagination,
            "response" => true
            );

        return new Response(json_encode($response));
    }

    /**
     * Creates new CMSComponentOnPage entity.
     *
     * @Route("/create", name="cmscomponentonpage_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new CMSComponentOnPage;

        $form = $this->createForm(new CMSComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Dodawanie komponentu zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSComponentOnPage:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to create a new CMSComponentOnPage entity.
     *
     * @Route("/new", name="cmscomponentonpage_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new CMSComponentOnPage();
        $form = $this->createForm(new CMSComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:CMSComponentOnPage:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
                );

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to edit an existing CMSComponentOnPage entity.
     *
     * @Route("/{id}/edit", name="cmscomponentonpage_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
        }

        $editForm = $this->createForm(new CMSComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));

        $view = $this->renderView('MyCMSBundle:CMSComponentOnPage:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Edits an existing CMSComponentOnPage entity.
     *
     * @Route("/{id}/update", name="cmscomponentonpage_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
        }

        $editForm = $this->createForm(new CMSComponentOnPageType(), $entity, array('attr' => array(
            'menuId' => $menuId)));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Edycja komponentu zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSComponentOnPage:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Deletes a CMSComponentOnPage entity.
     *
     * @Route("/delete", name="cmscomponentonpage_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
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
     * Change state a CMSComponentOnPage entity.
     *
     * @Route("/state", name="cmscomponentonpage_state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
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
