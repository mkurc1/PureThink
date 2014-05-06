<?php

namespace Purethink\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ComponentHasElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('componentHasValues', 'sonata_type_collection', ['type' => new ComponentHasValueType()]);
    }

    public function getName()
    {
        return 'purethink_cmsbundle_componenthaselement';
    }
}
