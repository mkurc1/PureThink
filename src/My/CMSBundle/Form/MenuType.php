<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Nazwa menu', 'attr' => ['class' => 'name']])
            ->add('article', 'entity', [
                'label'       => 'Wybierz artykuł',
                'class'       => 'MyCMSBundle:Article',
                'empty_value' => '',
                'attr'        => ['class' => 'sintetic-select']
            ])
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
                'empty_value'   => '',
                'attr'          => ['class' => 'sintetic-select']
            ])
            ->add('isNewPage', 'choice', [
                'label'   => 'Otwórz na nowej stronie',
                'choices' => [true => 'Tak', false => 'Nie'],
                'attr'    => ['class' => 'sintetic-select']
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\Menu',
            'menuId'     => null
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'my_cmsbundle_menu';
    }
}
