<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use My\CMSBundle\Entity\ComponentHasColumn;

class ComponentHasColumnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nazwa kolumny',
                'attr' => array(
                    'class' => 'name'
                    )
                )
            )
            ->add('columnLabel', 'text', array(
                'label' => 'Etykieta'
                )
            )
            ->add('class', 'text', array(
                'required' => false,
                'label' => 'Class'
                )
            )
            ->add('isRequired', 'choice', array(
                'label' => 'Czy wymagane',
                'choices' => array(
                    true => 'Tak',
                    false => 'Nie'
                    ),
                'attr' => array(
                        'class' => 'sintetic-select'
                    )
                )
            )
            ->add('columnType', 'choice', array(
                'label' => 'Wybierz typ',
                'choices' => ComponentHasColumn::$avilableColumnType,
                'empty_value' => '',
                'attr' => array(
                    'class' => 'sintetic-select'
                    )
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\CMSBundle\Entity\ComponentHasColumn'
        ));
    }

    public function getName()
    {
        return 'my_cmsbundle_componenthascolumn';
    }
}
