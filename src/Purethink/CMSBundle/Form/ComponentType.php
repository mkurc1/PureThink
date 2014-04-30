<?php

namespace Purethink\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Nazwa komponentu', 'attr' => ['class' => 'name']])
            ->add('extension', 'entity', [
                'label'       => 'Rozszerzenie',
                'class'       => 'PurethinkCMSBundle:Extension'
            ])
            ->add('language', 'entity', [
                'label'       => 'Język',
                'class'       => 'PurethinkCMSBundle:Language'
            ])
            ->add('series', 'series', ['menuId' => $options['menuId']]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Purethink\CMSBundle\Entity\Component',
            'menuId'     => null
        ]);
    }

    public function getName()
    {
        return 'purethink_cmsbundle_component';
    }
}
