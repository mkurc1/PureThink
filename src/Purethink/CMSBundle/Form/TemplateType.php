<?php

namespace Purethink\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nazwa szablonu', 'attr' => ['class' => 'name']])
            ->add('author', null, ['label' => 'Autor'])
            ->add('series', 'series', ['menuId' => $options['menuId']])
            ->add('styles', 'collection', [
                'type' => new StyleType(),
                'label' => 'Wybierz style',
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label_attr' => ['class' => 'line']
            ])
            ->add('scripts', 'collection', [
                'type' => new ScriptType(),
                'label' => 'Wybierz skrypty',
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label_attr' => ['class' => 'line']
            ])
            ->add('images', 'collection', [
                'type' => new ScriptType(),
                'label' => 'Wybierz zdjęcia',
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label_attr' => ['class' => 'line']
            ]);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Purethink\CMSBundle\Entity\Template',
            'menuId'     => null
        ]);
    }

    public function getName()
    {
        return 'purethink_cmsbundle_template';
    }
}
