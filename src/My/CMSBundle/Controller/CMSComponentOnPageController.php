<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentOnPage;
use My\CMSBundle\Form\CMSComponentOnPageType;

/**
 * CMSComponentOnPage controller.
 *
 * @Route("/component")
 */
class CMSComponentOnPageController extends Controller
{

    /**
     * Lists all CMSComponentOnPage entities.
     *
     * @Route("/", name="cmscomponentonpage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CMSComponentOnPage entity.
     *
     * @Route("/", name="cmscomponentonpage_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSComponentOnPage:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CMSComponentOnPage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponentonpage_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a CMSComponentOnPage entity.
    *
    * @param CMSComponentOnPage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CMSComponentOnPage $entity)
    {
        $form = $this->createForm(new CMSComponentOnPageType(), $entity, array(
            'action' => $this->generateUrl('cmscomponentonpage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CMSComponentOnPage entity.
     *
     * @Route("/new", name="cmscomponentonpage_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CMSComponentOnPage();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CMSComponentOnPage entity.
     *
     * @Route("/{id}", name="cmscomponentonpage_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CMSComponentOnPage entity.
     *
     * @Route("/{id}/edit", name="cmscomponentonpage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
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
    * Creates a form to edit a CMSComponentOnPage entity.
    *
    * @param CMSComponentOnPage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CMSComponentOnPage $entity)
    {
        $form = $this->createForm(new CMSComponentOnPageType(), $entity, array(
            'action' => $this->generateUrl('cmscomponentonpage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CMSComponentOnPage entity.
     *
     * @Route("/{id}", name="cmscomponentonpage_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSComponentOnPage:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponentonpage_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CMSComponentOnPage entity.
     *
     * @Route("/{id}", name="cmscomponentonpage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSComponentOnPage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cmscomponentonpage'));
    }

    /**
     * Creates a form to delete a CMSComponentOnPage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cmscomponentonpage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
