<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', ['required' => false, 'label' => 'Wybierz plik']);
    }

    public function getName()
    {
        return 'my_cmsbundle_file';
    }
}
