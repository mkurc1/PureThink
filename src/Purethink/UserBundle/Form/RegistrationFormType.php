<?php

namespace Purethink\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstName', null, ['label' => 'Imię'])
            ->add('lastName', null, ['label' => 'Nazwisko'])
            ;
    }

    public function getName()
    {
        return 'purethink_user_registration';
    }
}