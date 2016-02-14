<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use AppBundle\Entity\Menu;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class MenuAdmin extends Admin
{
    protected $parentAssociationMapping = 'type';

    protected $datagridValues = [
        '_sort_by'  => 'name',
        'createdAt' => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt' => ['type' => DateType::TYPE_GREATER_THAN]
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.general', ['class' => 'col-md-8'])
            ->add('name', null, [
                'label' => 'admin.menu.name'
            ])
            ->add('typeOfLink', 'choice', [
                'label'    => 'admin.menu.type_of_link',
                'multiple' => false,
                'expanded' => true,
                'choices'  => Menu::$linkTypes
            ])
            ->add('article', 'sonata_type_model_list', [
                'label'   => 'admin.menu.article',
                'btn_add' => false
            ])
            ->add('url', 'url', [
                'label'    => 'admin.menu.url',
                'required' => false
            ])
            ->add('menu', 'sonata_type_model_list', [
                'label'    => 'admin.menu.menu',
                'help'     => 'admin.menu.menu_help',
                'required' => false,
                'btn_add'  => false
            ])
            ->end()
            ->with('admin.options', ['class' => 'col-md-4'])
            ->add('language', null, [
                'label' => 'admin.menu.language'
            ])
            ->add('published', null, [
                'label' => 'admin.menu.published'
            ])
            ->add('isNewPage', null, [
                'label' => 'admin.menu.is_new_page'
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'admin.id'
            ])
            ->add('name', null, [
                'label' => 'admin.menu.name'
            ])
            ->add('article', null, [
                'label' => 'admin.menu.article'
            ])
            ->add('language', null, [
                'label' => 'admin.menu.language'
            ])
            ->add('published', null, [
                'label' => 'admin.menu.published'
            ])
            ->add('createdAt', 'doctrine_orm_datetime', [
                'label'         => 'admin.created_at',
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ])
            ->add('updatedAt', 'doctrine_orm_datetime', [
                'label'         => 'admin.updated_at',
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'admin.id'
            ])
            ->addIdentifier('name', null, [
                'label' => 'admin.menu.name'
            ])
            ->add('menu', null, [
                'label' => 'admin.menu.menu'
            ])
            ->add('position', null, [
                'label'    => 'admin.menu.position',
                'editable' => true
            ])
            ->add('typeOfLink', 'choice', [
                'label'   => 'admin.menu.type_of_link',
                'choices' => Menu::$linkTypes
            ])
            ->add('article', null, [
                'label' => 'admin.menu.article'
            ])
            ->add('url', null, [
                'label' => 'admin.menu.url'
            ])
            ->add('language', null, [
                'label' => 'admin.menu.language'
            ])
            ->add('published', null, [
                'label'    => 'admin.menu.published',
                'editable' => true
            ])
            ->add('createdAt', null, [
                'label' => 'admin.created_at'
            ])
            ->add('updatedAt', null, [
                'label' => 'admin.updated_at'
            ]);
    }

}
