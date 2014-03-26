<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use My\BackendBundle\Form\MetadataType;

class WebSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('metadata', new MetadataType(), ['required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'My\CMSBundle\Entity\WebSite',
            'cascade_validation' => true,
            'validation_groups'  => ['Default', 'website'],
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_websitetype';
    }
}