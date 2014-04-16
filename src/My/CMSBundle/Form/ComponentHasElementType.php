<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ComponentHasElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('componentHasValues', 'collection', ['type' => new ComponentHasValueType()]);
    }

    public function getName()
    {
        return 'my_cmsbundle_componenthaselement';
    }
}
