<?php
namespace Purethink\CMSBundle\Admin;

use Purethink\CMSBundle\Form\ImageType;
use Purethink\CMSBundle\Form\ScriptType;
use Purethink\CMSBundle\Form\StyleType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Extension extends Admin
{
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
            ->add('name')
            ->add('createdAt')
            ->add('updatedAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('createdAt')
            ->add('updatedAt');
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
        foreach ($object->getFields() as $image) {
            $image->setExtension($object);
        }
    }
}
