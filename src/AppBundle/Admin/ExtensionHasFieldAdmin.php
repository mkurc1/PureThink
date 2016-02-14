<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\ExtensionHasField;

class ExtensionHasFieldAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, [
                'label' => 'admin.extension_has_field.name'
            ])
            ->add('position', 'hidden', [
                'label' => 'admin.extension_has_field.position',
                'attr'  => ["hidden" => true]
            ])
            ->add('labelOfField', null, [
                'label' => 'admin.extension_has_field.label_of_field'
            ])
            ->add('class', null, [
                'label'    => 'admin.extension_has_field.class',
                'required' => false
            ])
            ->add('required', null, [
                'label'    => 'admin.extension_has_field.required',
                'required' => false
            ])
            ->add('isMainField', null, [
                'label'    => 'admin.extension_has_field.is_main_field',
                'required' => false
            ])
            ->add('typeOfField', 'choice', [
                'label'   => 'admin.extension_has_field.type_of_field',
                'choices' => ExtensionHasField::$availableTypeOfField
            ]);
    }
}
