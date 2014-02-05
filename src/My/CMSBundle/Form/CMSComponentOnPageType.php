<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CMSComponentOnPageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nazwa komponentu',
                'attr' => array(
                    'class' => 'name'
                    )
                )
            )
            ->add('component', 'entity', array(
                'label' => 'Rozszerzenie',
                'class' => 'MyCMSBundle:CMSComponent',
                'empty_value' => '',
                'attr' => array(
                    'class' => 'sintetic-select'
                    )
                )
            )
            ->add('language', 'entity', array(
                'label' => 'Język',
                'class' => 'MyCMSBundle:CMSLanguage',
                'empty_value' => '',
                'attr' => array(
                    'class' => 'sintetic-select'
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

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\CMSBundle\Entity\CMSComponentOnPage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'my_cmsbundle_cmscomponentonpage';
    }
}
