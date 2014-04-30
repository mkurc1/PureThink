<?php

namespace Purethink\FileBundle\Form\Type;

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
            'class'       => 'PurethinkFileBundle:File',
            'empty_value' => ''
        ]);
    }
}