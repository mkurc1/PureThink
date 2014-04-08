<?php

namespace My\FileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Nazwa pliku', 'attr' => ['class' => 'name']])
            ->add('series', 'entity', [
                'label'         => 'Grupa',
                'class'         => 'MyBackendBundle:Series',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($options) {
                        return $er->getGroupsByMenuIdNoExecute($options['menuId']);
                    },
                'empty_value'   => '',
                'attr'          => ['class' => 'sintetic-select']
            ])
            ->add('file', 'file', ['label' => 'Wybierz plik', 'attr' => ['class' => 'hide']]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\FileBundle\Entity\File',
            'menuId'     => null
        ]);
    }

    public function getName()
    {
        return 'my_filebundle_file';
    }
}
