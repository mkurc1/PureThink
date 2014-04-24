<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', [
            'required' => true,
            'label' => 'Wybierz plik',
            'attr' => ['class' => 'hide']
        ]);
    }

    abstract public function getName();
}
