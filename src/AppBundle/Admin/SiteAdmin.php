<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SiteAdmin extends Admin
{
    protected $formOptions = [
        'cascade_validation' => true,
        'validation_groups'  => ['site', 'default']
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.general', ['class' => 'col-md-8'])
            ->add('metadata', 'sonata_type_admin', [
                'label'   => false,
                'delete'  => false,
                'btn_add' => false
            ])
            ->end()
            ->with('admin.options', ['class' => 'col-md-4'])
            ->add('language', null, [
                'label' => 'admin.site.language'
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'admin.id'
            ])
            ->add('metadata.title', null, [
                'label' => 'admin.site.title'
            ])
            ->add('language', null, [
                'label' => 'admin.site.language'
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'admin.id'
            ])
            ->addIdentifier('metadata.title', null, [
                'label' => 'admin.site.title'
            ])
            ->add('language', null, [
                'label' => 'admin.site.language'
            ]);
    }

}
