<?php

namespace Purethink\CMSBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ScriptType extends FileType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Purethink\CMSBundle\Entity\Script',
        ]);
    }

    public function getName()
    {
        return 'purethink_cmsbundle_script';
    }
}
