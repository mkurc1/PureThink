<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'File';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'class'       => 'AppBundle:Media',
            'empty_value' => ''
        ]);
    }
}