<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use My\BackendBundle\Form\MetadataType;

class CMSWebSiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('metadata', new MetadataType(), ['required' => false])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'My\CMSBundle\Entity\CMSWebSite',
            'cascade_validation' => true,
            'validation_groups'  => ['Default', 'website'],
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'my_cmsbundle_cmswebsitetype';
    }
}
