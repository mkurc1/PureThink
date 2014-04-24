<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StyleType extends FileType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\Style',
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_style';
    }
}
