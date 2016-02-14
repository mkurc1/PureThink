<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use AppBundle\Entity\Menu as Entity;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class Menu extends Admin
{
    protected $translationDomain = 'AppBundle';

    protected $parentAssociationMapping = 'type';

    protected $datagridValues = [
        '_sort_by'  => 'name',
        'createdAt' => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt' => ['type' => DateType::TYPE_GREATER_THAN]
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-8'])
            ->add('name')
            ->add('typeOfLink', 'choice', [
                'multiple' => false,
                'expanded' => true,
                'choices'  => Entity::$linkTypes
            ])
            ->add('article', 'sonata_type_model_list', [
                'btn_add' => false
            ])
            ->add('url', 'url', [
                'required' => false
            ])
            ->add('menu', 'sonata_type_model_list', [
                'required' => false,
                'btn_add'  => false
            ])
            ->end()
            ->with('Options', ['class' => 'col-md-4'])
            ->add('language')
            ->add('published')
            ->add('isNewPage')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('article')
            ->add('language')
            ->add('published')
            ->add('createdAt', 'doctrine_orm_datetime', [
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ])
            ->add('updatedAt', 'doctrine_orm_datetime', [
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('menu')
            ->add('position', null, ['editable' => true])
            ->add('typeOfLink', 'choice', [
                'choices' => Entity::$linkTypes
            ])
            ->add('article')
            ->add('url')
            ->add('language')
            ->add('published', null, ['editable' => true])
            ->add("createdAt")
            ->add('updatedAt');
    }

}
