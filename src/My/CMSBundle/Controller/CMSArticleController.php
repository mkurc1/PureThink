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

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSArticle')->getArticles($order, $sequence, $filtr);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $page,
            $rowsOnPage
        );

        $list = $this->renderView('MyCMSBundle:CMSArticle:_list.html.twig', array('entities' => $pagination));

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
     * @Route("/", name="cmsarticle_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSArticle:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CMSArticle();
        $form = $this->createForm(new CMSArticleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmsarticle_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new CMSArticle entity.
     *
     * @Route("/new", name="cmsarticle_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CMSArticle();
        $form   = $this->createForm(new CMSArticleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CMSArticle entity.
     *
     * @Route("/{id}/edit", name="cmsarticle_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSArticle entity.');
        }

        $editForm = $this->createForm(new CMSArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CMSArticle entity.
     *
     * @Route("/{id}", name="cmsarticle_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSArticle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSArticle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CMSArticleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmsarticle_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CMSArticle entity.
     *
     * @Route("/{id}", name="cmsarticle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSArticle entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cmsarticle'));
    }

    /**
     * Creates a form to delete a CMSArticle entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
