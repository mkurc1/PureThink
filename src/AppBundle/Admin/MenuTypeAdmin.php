<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class MenuTypeAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'name'
    ];

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            $this->trans('admin.menu_type.side_menu.menu'),
            ['uri' => $admin->generateUrl('edit', compact('id'))]
        );

        $menu->addChild(
            $this->trans('admin.menu_type.side_menu.elements'),
            ['uri' => $admin->getRouteGenerator()->generate('admin_app_menutype_menu_list', compact('id'))]
        );
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.general', ['class' => 'col-md-8'])
            ->add('name', null, [
                'label' => 'admin.menu_type.name'
            ])
            ->add('description', 'textarea', [
                'label' => 'admin.menu_type.description'
            ])
            ->end()
            ->with('admin.options', ['class' => 'col-md-4'])
            ->add('slug', null, [
                'label'    => 'admin.menu_type.slug',
                "required" => false
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
                'label' => 'admin.menu_type.name'
            ])
            ->add('slug', null, [
                'label' => 'admin.menu_type.slug'
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'admin.id',
                'route' => ['name' => 'app.admin.menu.list']
            ])
            ->addIdentifier('name', null, [
                'label' => 'admin.menu_type.name',
                'route' => ['name' => 'app.admin.menu.list']
            ])
            ->add('slug', null, [
                'label' => 'admin.menu_type.slug'
            ])
            ->add('description', null, [
                'label' => 'admin.menu_type.description'
            ])
            ->add('_action', 'actions', [
                'label'   => 'admin.actions',
                'actions' => [
                    'edit' => []
                ]
            ]);;
    }

}
