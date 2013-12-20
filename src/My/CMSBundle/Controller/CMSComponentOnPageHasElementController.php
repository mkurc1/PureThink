<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentOnPageHasElement;
use My\CMSBundle\Form\CMSComponentOnPageHasElementType;
use Symfony\Component\HttpFoundation\Response;

use My\BackendBundle\Pagination\Pagination as Pagination;

/**
 * CMSComponentOnPageHasElement controller.
 *
 * @Route("/component/element")
 */
class CMSComponentOnPageHasElementController extends Controller
{
    /**
     * Lists all CMSComponentOnPageHasElement entities.
     *
     * @Route("/", name="cmscomponentonpagehaselement")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CMSComponentOnPageHasElement entity.
     *
     * @Route("/", name="cmscomponentonpagehaselement_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSComponentOnPageHasElement:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CMSComponentOnPageHasElement();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponentonpagehaselement_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a CMSComponentOnPageHasElement entity.
    *
    * @param CMSComponentOnPageHasElement $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CMSComponentOnPageHasElement $entity)
    {
        $form = $this->createForm(new CMSComponentOnPageHasElementType(), $entity, array(
            'action' => $this->generateUrl('cmscomponentonpagehaselement_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CMSComponentOnPageHasElement entity.
     *
     * @Route("/new", name="cmscomponentonpagehaselement_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CMSComponentOnPageHasElement();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CMSComponentOnPageHasElement entity.
     *
     * @Route("/{id}", name="cmscomponentonpagehaselement_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CMSComponentOnPageHasElement entity.
     *
     * @Route("/{id}/edit", name="cmscomponentonpagehaselement_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
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
    * Creates a form to edit a CMSComponentOnPageHasElement entity.
    *
    * @param CMSComponentOnPageHasElement $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CMSComponentOnPageHasElement $entity)
    {
        $form = $this->createForm(new CMSComponentOnPageHasElementType(), $entity, array(
            'action' => $this->generateUrl('cmscomponentonpagehaselement_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CMSComponentOnPageHasElement entity.
     *
     * @Route("/{id}", name="cmscomponentonpagehaselement_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSComponentOnPageHasElement:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponentonpagehaselement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CMSComponentOnPageHasElement entity.
     *
     * @Route("/{id}", name="cmscomponentonpagehaselement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSComponentOnPageHasElement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cmscomponentonpagehaselement'));
    }

    /**
     * Creates a form to delete a CMSComponentOnPageHasElement entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cmscomponentonpagehaselement_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
