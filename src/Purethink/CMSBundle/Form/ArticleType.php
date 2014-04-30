<?php

namespace Purethink\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Nazwa artykułu', 'attr' => ['class' => 'name']])
            ->add('content', 'ckeditor', ['label' => 'Treść'])
            ->add('language', 'entity', [
                'label' => 'Język',
                'class' => 'PurethinkCMSBundle:Language'
            ])
            ->add('series', 'series', ['menuId' => $options['menuId']])
            ->add('metadata', 'metadata', ['required' => false]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Purethink\CMSBundle\Entity\Article',
            'cascade_validation' => true,
            'menuId'             => null
        ]);
    }

    public function getName()
    {
        return 'purethink_cmsbundle_articletype';
    }
}
