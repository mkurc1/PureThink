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
            ->add('name', 'text', array(
                'label' => 'Nazwa rozszerzenia',
                'attr' => array(
                    'class' => 'name'
                    )
                )
            )
            ->add('series', 'entity', array(
                'label' => 'Grupa',
                'class' => 'MyBackendBundle:Series',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($options) {
                    return $er->getGroupsByMenuIdNoExecute($options['attr']['menuId']);
                },
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
            'data_class' => 'My\CMSBundle\Entity\Component'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'my_cmsbundle_component';
    }
}
