<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Component extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('slug')
                ->add('isEnable')
                ->add('language')
                ->add('extension')
            ->end()
            ->with('Elements')
                ->add('elements', 'sonata_type_collection', [
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
            ->add('slug')
            ->add('extension')
            ->add('language')
            ->add('isEnable')
            ->add('createdAt')
            ->add('updatedAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier("slug")
            ->add('extension')
            ->add('language')
            ->add('isEnable', null, ['editable' => true])
            ->add("createdAt")
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
        foreach ($object->getElements() as $image) {
            $image->setComponent($object);
        }
    }
}
