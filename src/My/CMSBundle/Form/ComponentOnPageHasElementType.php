<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentOnPageHasElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('componentOnPageHasValues', 'collection', array(
            'type' => new ComponentOnPageHasValueType()
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\CMSBundle\Entity\ComponentOnPageHasElement'
        ));
    }

    public function getName()
    {
        return 'my_cmsbundle_componentonpagehaselement';
    }
}
