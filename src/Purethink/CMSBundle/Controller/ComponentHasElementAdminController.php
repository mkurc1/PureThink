<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\CMSBundle\Entity\ComponentHasArticle;
use Purethink\CMSBundle\Entity\ComponentHasElement;
use Purethink\CMSBundle\Entity\ComponentHasFile;
use Purethink\CMSBundle\Entity\ComponentHasText;
use Purethink\CMSBundle\Entity\ExtensionHasField;
use Purethink\CMSBundle\Form\ComponentHasElementType;
use Purethink\CMSBundle\Form\ComponentHasValueType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ComponentHasElementAdminController extends Controller
{
    public function createAction()
    {
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $form = $this->createForm(new ComponentHasElementType($object));
        $form = $this->addColumns($form, $object);

        if ($this->get('request')->getMethod() == 'POST') {
            $form->submit($this->get('request'));

            if ($form->isValid() && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $this->admin->create($object);

                $this->get('session')->getFlashBag()->add('sonata_flash_success', 'flash_create_success');

                return $this->redirectTo($object);
            } else {
                $this->get('session')->getFlashBag()->add('sonata_flash_error', 'flash_create_error');
            }
        }

        return $this->render($this->admin->getTemplate($templateKey), [
            'action' => 'create',
            'form'   => $form->createView(),
            'object' => $object,
        ]);

    }

    public function editAction($id = null)
    {
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('EDIT')) {
            throw new AccessDeniedException();
        }

        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->getEntityById($id);
        $this->admin->setSubject($object);

        $form = $this->createForm(new ComponentHasElementType($object));
        $form = $this->addColumns($form, $object);

        if ($this->get('request')->getMethod() == 'POST') {
            $form->submit($this->get('request'));

            if ($form->isValid() && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $this->admin->create($object);

                $this->get('session')->getFlashBag()->add('sonata_flash_success', 'flash_edit_success');

                return $this->redirectTo($object);
            } else {
                $this->get('session')->getFlashBag()->add('sonata_flash_error', 'flash_edit_error');
            }
        }

        return $this->render($this->admin->getTemplate($templateKey), [
            'action' => 'edit',
            'form'   => $form->createView(),
            'object' => $object,
        ]);

    }

    private function getComponentHasValueType(ComponentHasElement $entity, ExtensionHasField $field)
    {
        switch ($field->getTypeOfField()) {
            case ExtensionHasField::TYPE_ARTICLE:
                return new ComponentHasArticle($entity, $field);
                break;
            case ExtensionHasField::TYPE_FILE:
                return new ComponentHasFile($entity, $field);
                break;
            default:
                return new ComponentHasText($entity, $field);
        }
    }

    private function getColumns(ComponentHasElement $componentHasElement)
    {
        $fields = $componentHasElement->getComponent()->getExtension()->getFields();
        foreach ($fields as $field) {
            $componentHasValue = $this->getComponentHasValueType($componentHasElement, $field);

            $componentHasElement->addComponentHasValue($componentHasValue);
        }

        return $componentHasElement;
    }

    private function addColumns(Form $form, ComponentHasElement $componentHasElement)
    {
        if ($componentHasElement->getComponentHasValues()->count() == 0) {
            $componentHasElement = $this->getColumns($componentHasElement);
        }

        foreach ($componentHasElement->getComponentHasValues() as $key => $componentHasValue) {
            $form->get('componentHasValues')->add('column_' . $key, new ComponentHasValueType($componentHasValue));
        }

        return $form;
    }

    private function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:ComponentHasElement')
            ->find($id);
    }
}
