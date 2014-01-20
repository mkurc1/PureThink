<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CMSWebSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nazwa witryny',
                'attr' => array(
                    'class' => 'name'
                    ),
                'constraints' => array(
                    new NotBlank()
                    )
                )
            )
            ->add('description', 'textarea', array('label' => 'Opis', 'required' => false))
            ->add('keywords', 'textarea', array('label' => 'Słowa kluczowe', 'required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\CMSBundle\Entity\CMSWebSite'
        ));
    }

    public function getName()
    {
        return 'my_cmsbundle_cmswebsitetype';
    }
}
