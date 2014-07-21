<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Website extends Admin
{
    protected $translationDomain = 'PurethinkCMSBundle';

    protected $formOptions = [
        'cascade_validation' => true,
        'validation_groups'  => ['website', 'default']
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-8'])
                ->add('metadata', 'sonata_type_admin', [
                    'label'   => false,
                    'delete'  => false,
                    'btn_add' => false
                ])
            ->end()
            ->with('Options', ['class' => 'col-md-4'])
                ->add('language')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('metadata.title', null, ['label' => 'Name'])
            ->add('language');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('metadata.title', null, ['label' => 'Name'])
            ->add('language');
    }

}
