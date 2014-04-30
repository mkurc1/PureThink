<?php

namespace Purethink\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class UserType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('groups', null, ['label' => 'Grupy']);
    }

    public function getName()
    {
        return 'purethink_userbundle_user';
    }
}
