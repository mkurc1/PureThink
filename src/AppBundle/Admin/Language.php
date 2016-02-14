<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Language extends Admin
{
    protected $translationDomain = 'AppBundle';

    protected $datagridValues = [
        '_sort_by' => 'name'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-8'])
            ->add('name')
            ->add('alias')
            ->end()
            ->with('Options', ['class' => 'col-md-4'])
            ->add('enabled', null, ['required' => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('alias')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add("alias")
            ->add('enabled', null, ['editable' => true]);
    }

}
