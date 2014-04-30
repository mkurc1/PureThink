<?php

namespace Purethink\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MetadataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', ['label' => 'Tytuł', 'required' => false])
            ->add('description', 'textarea', ['label' => 'Opis', 'required' => false])
            ->add('keyword', 'textarea', ['label' => 'Słowa kluczowe', 'required' => false]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Purethink\AdminBundle\Entity\Metadata'
        ]);
    }

    public function getName()
    {
        return 'metadata';
    }
}
