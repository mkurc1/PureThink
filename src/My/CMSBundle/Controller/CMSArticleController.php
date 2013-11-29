<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSArticle;
use My\CMSBundle\Form\CMSArticleType;
use Symfony\Component\HttpFoundation\Response;

use My\BackendBundle\Pagination\Pagination as Pagination;

/**
 * CMSArticle controller.
 *
 * @Route("/article")
 */
class CMSArticleController extends Controller
{

    /**
     * Lists all CMSArticle entities.
     *
     * @Route("/", name="cmsarticle")
     * @Method("POST")
     */
    public function listAction()
    {
        $request = $this->container->get('request');

        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page = (int)$request->get('page', 1);
        $order = $request->get('order', 'a.name');
        $sequence = $request->get('sequence', 'ASC');
        $filtr = $request->get('filtr');
        $languageId = $request->get('languageId');
        $groupId = $request->get('groupId');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSArticle')->getArticles($order, $sequence, $filtr, $languageId, $groupId);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $page,
            $rowsOnPage
        );

        $list = $this->renderView('MyCMSBundle:CMSArticle:_list.html.twig', array('entities' => $pagination, 'page' => $page, 'rowsOnPage' => $rowsOnPage));

        $response = array(
            "list" => $list,
            "pagination" => Pagination::helper($pagination),
            "response" => true
            );

        return new Response(json_encode($response));
    }

    /**
     * Creates a new CMSArticle entity.
     *
     * @Route("/create", name="cmsarticle_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSArticle:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CMSArticle();
        $entity->setUser($this->getUser());

        $form = $this->createForm(new CMSArticleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Dodawanie artykułu zakończyło się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSArticle:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to create a new CMSArticle entity.
     *
     * @Route("/new", name="cmsarticle_new")
     * @Method("POST")
     */
    public function newAction()
    {
        $entity = new CMSArticle();
        $form   = $this->createForm(new CMSArticleType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSArticle:_new.html.twig', array('entity' => $entity, 'form' => $form->createView()));

        $response = array(
                "response" => true,
                "view" => $view
                );

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to edit an existing CMSArticle entity.
     *
     * @Route("/{id}/edit", name="cmsarticle_edit")
     * @Method("POST")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSArticle entity.');
        }

        $editForm = $this->createForm(new CMSArticleType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSArticle:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Edits an existing CMSArticle entity.
     *
     * @Route("/{id}/update", name="cmsarticle_update")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSArticle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSArticle entity.');
        }

        $editForm = $this->createForm(new CMSArticleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Edycja artykułu zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:CMSArticle:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }
    /**
     * Deletes a CMSArticle entity.
     *
     * @Route("/delete", name="cmsarticle_delete")
     * @Method("POST")
     */
    public function deleteAction()
    {
        $request = $this->container->get('request');

        $arrayId = $request->get('arrayId');

        $em = $this->getDoctrine()->getManager();

        foreach ($arrayId as $id) {
            $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find((int)$id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSArticle entity.');
            }

            $em->remove($entity);
        }

        try {
            $em->flush();

            if (count($arrayId) > 1) {
                $message = 'Usuwanie artykułów zakończyło się powodzeniem';
            }
            else {
                $message = 'Usuwanie artykułu zakończyło się powodzeniem';
            }

            $response = array(
                "response" => true,
                "message" => $message
                );
        } catch (\Exception $e) {
            if (count($arrayId) > 1) {
                $message = 'Usuwanie artykułów zakończyło się niepowodzeniem';
            }
            else {
                $message = 'Usuwanie artykułu zakończyło się niepowodzeniem';
            }

            $response = array(
                "response" => false,
                "message" => $message
                );
        }

        return new Response(json_encode($response));
    }
}
