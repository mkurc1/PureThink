<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentOnPageHasValue;
use My\CMSBundle\Form\CMSComponentOnPageHasValueType;

/**
 * CMSComponentOnPageHasValue controller.
 *
 * @Route("/cmscomponentonpagehasvalue")
 */
class CMSComponentOnPageHasValueController extends Controller
{

    /**
     * Lists all CMSComponentOnPageHasValue entities.
     *
     * @Route("/", name="cmscomponentonpagehasvalue")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CMSComponentOnPageHasValue entity.
     *
     * @Route("/", name="cmscomponentonpagehasvalue_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSComponentOnPageHasValue:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CMSComponentOnPageHasValue();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponentonpagehasvalue_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a CMSComponentOnPageHasValue entity.
    *
    * @param CMSComponentOnPageHasValue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CMSComponentOnPageHasValue $entity)
    {
        $form = $this->createForm(new CMSComponentOnPageHasValueType(), $entity, array(
            'action' => $this->generateUrl('cmscomponentonpagehasvalue_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CMSComponentOnPageHasValue entity.
     *
     * @Route("/new", name="cmscomponentonpagehasvalue_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CMSComponentOnPageHasValue();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CMSComponentOnPageHasValue entity.
     *
     * @Route("/{id}", name="cmscomponentonpagehasvalue_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasValue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CMSComponentOnPageHasValue entity.
     *
     * @Route("/{id}/edit", name="cmscomponentonpagehasvalue_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasValue entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CMSComponentOnPageHasValue entity.
    *
    * @param CMSComponentOnPageHasValue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CMSComponentOnPageHasValue $entity)
    {
        $form = $this->createForm(new CMSComponentOnPageHasValueType(), $entity, array(
            'action' => $this->generateUrl('cmscomponentonpagehasvalue_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CMSComponentOnPageHasValue entity.
     *
     * @Route("/{id}", name="cmscomponentonpagehasvalue_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSComponentOnPageHasValue:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasValue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponentonpagehasvalue_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CMSComponentOnPageHasValue entity.
     *
     * @Route("/{id}", name="cmscomponentonpagehasvalue_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasValue entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cmscomponentonpagehasvalue'));
    }

    /**
     * Creates a form to delete a CMSComponentOnPageHasValue entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cmscomponentonpagehasvalue_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
