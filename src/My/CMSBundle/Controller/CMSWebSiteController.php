<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSWebSite;
use My\CMSBundle\Form\CMSWebSiteType;

/**
 * CMSWebSite controller.
 *
 * @Route("/website")
 */
class CMSWebSiteController extends Controller
{

    /**
     * Lists all CMSWebSite entities.
     *
     * @Route("/", name="cmswebsite")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSWebSite')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CMSWebSite entity.
     *
     * @Route("/", name="cmswebsite_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSWebSite:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new CMSWebSite();
        $form = $this->createForm(new CMSWebSiteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmswebsite_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new CMSWebSite entity.
     *
     * @Route("/new", name="cmswebsite_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CMSWebSite();
        $form   = $this->createForm(new CMSWebSiteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CMSWebSite entity.
     *
     * @Route("/{id}", name="cmswebsite_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSWebSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSWebSite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CMSWebSite entity.
     *
     * @Route("/{id}/edit", name="cmswebsite_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSWebSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSWebSite entity.');
        }

        $editForm = $this->createForm(new CMSWebSiteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing CMSWebSite entity.
     *
     * @Route("/{id}", name="cmswebsite_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSWebSite:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSWebSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSWebSite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CMSWebSiteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmswebsite_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CMSWebSite entity.
     *
     * @Route("/{id}", name="cmswebsite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyCMSBundle:CMSWebSite')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSWebSite entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cmswebsite'));
    }

    /**
     * Creates a form to delete a CMSWebSite entity by id.
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
