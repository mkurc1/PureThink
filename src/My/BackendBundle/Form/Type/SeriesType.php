<?php

namespace My\BackendBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

class SeriesType extends AbstractType
{
    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'series';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'label'         => 'Grupa',
            'class'         => 'MyBackendBundle:Series',
            'menuId'        => null,
            'query_builder' => function (Options $options) {
                    return function (EntityRepository $er) use ($options) {
                        return $er->getGroupsByMenuIdQb($options['menuId']);
                    };
                }
        ]);
    }
}