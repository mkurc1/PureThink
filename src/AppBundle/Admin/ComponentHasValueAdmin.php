<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotNull;
use AppBundle\Entity\ComponentHasValue;

class ComponentHasValueAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getSubject();
        /** @var ComponentHasValue $object */
        $field = $object->getExtensionHasField();

        $formMapper->add('content', $field->getTypeOfFieldString(), [
            'required'    => $field->getRequired(),
            'label'       => $field->getLabelOfField(),
            'attr'        => ['class' => $field->getClass()],
            'constraints' => $field->getRequired() ? [new NotNull()] : null
        ]);
    }
}
