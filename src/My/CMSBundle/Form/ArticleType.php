<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use My\BackendBundle\Form\MetadataType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Nazwa artykułu', 'attr' => ['class' => 'name']])
            ->add('content', 'ckeditor', ['label' => 'Treść'])
            ->add('language', 'entity', [
                'label'       => 'Język',
                'class'       => 'MyCMSBundle:Language',
                'empty_value' => '',
                'attr'        => ['class' => 'sintetic-select']
            ])
            ->add('series', 'entity', [
                'label'         => 'Grupa',
                'class'         => 'MyBackendBundle:Series',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($options) {
                    return $er->getGroupsByMenuIdNoExecute($options['menuId']);
                },
                'empty_value' => '',
                'attr'        => ['class' => 'sintetic-select']
            ])
            ->add('metadata', new MetadataType(), ['required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'My\CMSBundle\Entity\Article',
            'cascade_validation' => true,
            'menuId'             => null
        ));
    }

    public function getName()
    {
        return 'my_cmsbundle_articletype';
    }
}
