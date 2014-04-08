<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use My\CMSBundle\Entity\ExtensionHasField;

class ExtensionHasFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Nazwa kolumny', 'attr' => ['class' => 'name']])
            ->add('labelOfField', 'text', ['label' => 'Etykieta'])
            ->add('class', 'text', ['required' => false, 'label' => 'Class'])
            ->add('isRequired', 'choice', [
                    'label'   => 'Czy wymagane',
                    'choices' => [true => 'Tak', false => 'Nie'],
                    'attr'    => ['class' => 'sintetic-select']
                ]
            )
            ->add('typeOfField', 'choice', [
                'label'       => 'Wybierz typ',
                'choices'     => ExtensionHasField::$avilableTypeOfField,
                'empty_value' => '',
                'attr'        => ['class' => 'sintetic-select']
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\ExtensionHasField',
            'menuId'     => null
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_extensionhasfield';
    }
}
