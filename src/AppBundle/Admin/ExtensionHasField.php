<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\ExtensionHasField as Field;

class ExtensionHasField extends Admin
{
    protected $translationDomain = 'AppBundle';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('position', 'hidden', ['attr' => ["hidden" => true]])
            ->add('labelOfField')
            ->add('class', null, ['required' => false])
            ->add('required', null, ['required' => false])
            ->add('isMainField', null, ['required' => false])
            ->add('typeOfField', 'choice', [
                'choices' => Field::$availableTypeOfField
            ]);
    }
}
