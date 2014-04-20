<?php

namespace My\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\File;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', [
            'label' => 'Wybierz plik',
            'mapped' => false,
            'attr' => ['class' => 'hide'],
            'constraints' => [
                new NotNull(),
                new File(['mimeTypes' => ['text/x-json', 'text/html']])
            ]
        ]);
    }

    public function getName()
    {
        return 'my_backendbundle_import';
    }
}
