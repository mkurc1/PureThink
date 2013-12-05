<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class CMSMenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nazwa menu',
                'constraints' => array(
                    new NotBlank()
                    )
                )
            )
            ->add('article', 'entity', array(
                'label' => 'Wybierz artykuł',
                'class' => 'MyCMSBundle:CMSArticle',
                'empty_value' => '',
                'attr' => array(
                    'class' => 'sintetic-select'
                    ),
                'constraints' => array(
                    new NotNull()
                    )
                )
            )
            ->add('sequence', 'text', array(
                'label' => 'Kolejność',
                'constraints' => array(
                    new NotBlank()
                    )
                )
            )
            ->add('menu', 'entity', array(
                'label' => 'Wybierz menu',
                'class' => 'MyCMSBundle:CMSMenu',
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
                    ),
                'constraints' => array(
                    new NotNull()
                    )
                )
            )
            ->add('series', 'entity', array(
                'label' => 'Grupa',
                'class' => 'MyBackendBundle:Series',
                'empty_value' => '',
                'attr' => array(
                    'class' => 'sintetic-select'
                    ),
                'constraints' => array(
                    new NotNull()
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
            'data_class' => 'My\CMSBundle\Entity\CMSMenu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'my_cmsbundle_cmsmenu';
    }
}
