<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Extension extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'name'
    ];

    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
            ->end()
            ->with('Fields')
                ->add('fields', 'sonata_type_collection', [
                    'required' => true
                ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('created')
            ->add('updated');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('created')
            ->add('updated');
    }

    public function prePersist($object)
    {
        $this->setExtensionForCollections($object);
    }

    public function preUpdate($object)
    {
        $this->setExtensionForCollections($object);
    }

    private function setExtensionForCollections($object)
    {
        foreach ($object->getFields() as $field) {
            $field->setExtension($object);
        }
    }
}
