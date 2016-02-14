<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AdminHelper as BaseAdminHelper;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Exception\NoValueException;

class AdminHelper extends BaseAdminHelper
{
    public function appendFormFieldElement(AdminInterface $admin, $subject, $elementId)
    {
        // retrieve the subject
        $formBuilder = $admin->getFormBuilder();

        $form = $formBuilder->getForm();
        $form->setData($subject);
        $form->submit($admin->getRequest());

        // get the field element
        $childFormBuilder = $this->getChildFormBuilder($formBuilder, $elementId);

        // retrieve the FieldDescription
        $fieldDescription = $admin->getFormFieldDescription($childFormBuilder->getName());

        try {
            $value = $fieldDescription->getValue($form->getData());
        } catch (NoValueException $e) {
            $value = null;
        }

        // retrieve the posted data
        $data = $admin->getRequest()->get($formBuilder->getName());

        if (!isset($data[$childFormBuilder->getName()])) {
            $data[$childFormBuilder->getName()] = array();
        }

        $objectCount = count($value);
        $postCount   = count($data[$childFormBuilder->getName()]);

        $fields = array_keys($fieldDescription->getAssociationAdmin()->getFormFieldDescriptions());

        // for now, not sure how to do that
        $value = array();
        foreach ($fields as $name) {
            $value[$name] = '';
        }

        // add new elements to the subject
        while ($objectCount < $postCount) {
            // append a new instance into the object
            $this->addNewInstance($form->getData(), $fieldDescription);
            ++$objectCount;
        }

        $this->addNewInstance($form->getData(), $fieldDescription);

        $finalForm = $admin->getFormBuilder()->getForm();
        $finalForm->setData($subject);

        // bind the data
        $finalForm->setData($form->getData());

        return array($fieldDescription, $finalForm);
    }
}