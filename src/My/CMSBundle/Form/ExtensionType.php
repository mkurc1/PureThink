<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExtensionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Nazwa rozszerzenia', 'attr' => ['class' => 'name']])
            ->add('series', 'series', ['menuId' => $options['menuId']]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\Extension',
            'menuId'     => null
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_extension';
    }
}
