<?php

namespace My\CMSBundle\Form;

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
                'class'       => 'MyCMSBundle:Extension',
                'empty_value' => '',
                'attr'        => ['class' => 'sintetic-select']
            ])
            ->add('language', 'entity', [
                'label'       => 'Język',
                'class'       => 'MyCMSBundle:Language',
                'empty_value' => '',
                'attr'        => ['class' => 'sintetic-select']
            ])
            ->add('series', 'entity', [
                'label'         => 'Grupa',
                'class'         => 'MyBackendBundle:Series',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($options) {
                        return $er->getGroupsByMenuIdNoExecute($options['menuId']);
                    },
                'empty_value'   => '',
                'attr'          => ['class' => 'sintetic-select']
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\Component',
            'menuId'     => null
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_component';
    }
}
