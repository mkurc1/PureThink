<?php
namespace AppBundle\Admin;

use AppBundle\Entity\ExtensionHasField;
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

        switch ($field->getTypeOfField()) {
            case ExtensionHasField::TYPE_ARTICLE:
                $formMapper->add('article', 'sonata_type_model_list', [
                    'required'    => $field->getRequired(),
                    'btn_delete'  => !$field->getRequired(),
                    'btn_add'     => false,
                    'label'       => $field->getLabelOfField(),
                    'constraints' => $field->getRequired() ? [new NotNull()] : null
                ]);
                break;
            case ExtensionHasField::TYPE_FILE:
                $formMapper->add('file', 'sonata_type_model_list', [
                    'required'    => $field->getRequired(),
                    'btn_delete'  => !$field->getRequired(),
                    'label'       => $field->getLabelOfField(),
                    'constraints' => $field->getRequired() ? [new NotNull()] : null
                ]);
                break;
            default:
                $formMapper->add('content', $field->getTypeOfFieldString(), [
                    'required'    => $field->getRequired(),
                    'label'       => $field->getLabelOfField(),
                    'constraints' => $field->getRequired() ? [new NotNull()] : null
                ]);
        }
    }
}
