<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotNull;
use AppBundle\Entity\ComponentHasValue as ComponentHasValueEntity;

class ComponentHasValue extends Admin
{
    protected $translationDomain = 'AppBundle';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getSubject();
        /** @var ComponentHasValueEntity $object */
        $field = $object->getExtensionHasField();

        $formMapper->add('content', $field->getTypeOfFieldString(), [
            'required'    => $field->getRequired(),
            'label'       => $field->getLabelOfField(),
            'attr'        => ['class' => $field->getClass()],
            'constraints' => $field->getRequired() ? [new NotNull()] : null
        ]);
    }
}
