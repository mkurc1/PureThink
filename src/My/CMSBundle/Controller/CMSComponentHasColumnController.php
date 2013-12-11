<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSComponentHasColumn;
use My\CMSBundle\Form\CMSComponentHasColumnType;

/**
 * CMSComponentHasColumn controller.
 *
 * @Route("/cmscomponenthascolumn")
 */
class CMSComponentHasColumnController extends Controller
{

    /**
     * Lists all CMSComponentHasColumn entities.
     *
     * @Route("/", name="cmscomponenthascolumn")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CMSComponentHasColumn entity.
     *
     * @Route("/", name="cmscomponenthascolumn_create")
     * @Method("POST")
     * @Template("MyCMSBundle:CMSComponentHasColumn:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CMSComponentHasColumn();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponenthascolumn_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a CMSComponentHasColumn entity.
    *
    * @param CMSComponentHasColumn $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CMSComponentHasColumn $entity)
    {
        $form = $this->createForm(new CMSComponentHasColumnType(), $entity, array(
            'action' => $this->generateUrl('cmscomponenthascolumn_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CMSComponentHasColumn entity.
     *
     * @Route("/new", name="cmscomponenthascolumn_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CMSComponentHasColumn();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CMSComponentHasColumn entity.
     *
     * @Route("/{id}", name="cmscomponenthascolumn_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CMSComponentHasColumn entity.
     *
     * @Route("/{id}/edit", name="cmscomponenthascolumn_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
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
    * Creates a form to edit a CMSComponentHasColumn entity.
    *
    * @param CMSComponentHasColumn $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CMSComponentHasColumn $entity)
    {
        $form = $this->createForm(new CMSComponentHasColumnType(), $entity, array(
            'action' => $this->generateUrl('cmscomponenthascolumn_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CMSComponentHasColumn entity.
     *
     * @Route("/{id}", name="cmscomponenthascolumn_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSComponentHasColumn:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cmscomponenthascolumn_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CMSComponentHasColumn entity.
     *
     * @Route("/{id}", name="cmscomponenthascolumn_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CMSComponentHasColumn entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cmscomponenthascolumn'));
    }

    /**
     * Creates a form to delete a CMSComponentHasColumn entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cmscomponenthascolumn_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
