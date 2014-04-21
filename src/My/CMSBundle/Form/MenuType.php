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
            ->add('article', 'Article')
            ->add('language', 'entity', [
                'label' => 'Język',
                'class' => 'MyCMSBundle:Language'
            ])
            ->add('series', 'series', ['menuId' => $options['menuId']])
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
