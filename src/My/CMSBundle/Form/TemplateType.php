<?php

namespace My\CMSBundle\Form;

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
            ->add('series', 'series', ['menuId' => $options['menuId']]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\Template',
            'menuId'     => null
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_template';
    }
}
