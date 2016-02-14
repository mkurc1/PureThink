<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'Article';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'class'       => 'AppBundle:Article',
            'empty_value' => ''
        ]);
    }
}