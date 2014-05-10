<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Website extends Admin
{
    protected $formOptions = [
        'cascade_validation' => true,
        'validation_groups'  => ['website', 'default']
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('metadata', 'sonata_type_admin', [
                    'label'   => false,
                    'delete'  => false,
                    'btn_add' => false
                ])
                ->add('language')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('metadata')
            ->add('language');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('metadata.title')
            ->add('language');
    }

}
