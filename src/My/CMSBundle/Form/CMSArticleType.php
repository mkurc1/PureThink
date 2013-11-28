<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class CMSArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nazwa artykułu',
                'constraints' => array(
                    new NotBlank()
                    )
                )
            )
            ->add('description', 'textarea', array('label' => 'Opis'))
            ->add('keywords', 'textarea', array('label' => 'Słowa kluczowe'))
            ->add('content', 'ckeditor', array('label' => 'Treść'))
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\CMSBundle\Entity\CMSArticle'
        ));
    }

    public function getName()
    {
        return 'my_cmsbundle_cmsarticletype';
    }
}
