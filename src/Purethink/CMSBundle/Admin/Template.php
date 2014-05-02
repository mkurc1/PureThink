<?php
namespace Purethink\CMSBundle\Admin;

use Purethink\CMSBundle\Form\ImageType;
use Purethink\CMSBundle\Form\ScriptType;
use Purethink\CMSBundle\Form\StyleType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Template extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('slug', null, ['required' => false])
                ->add('author')
                ->add('isEnable')
            ->end()
            ->with('Style')
                ->add('styles', 'sonata_type_collection', [
                    'required' => false
                ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                ])
            ->end()
            ->with('Script')
                ->add('scripts', 'sonata_type_collection', [
                    'required' => false
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ])
            ->end()
            ->with('Image')
                ->add('images', 'sonata_type_collection', [
                    'required' => false
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
            ->add('author')
            ->add('isEnable');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('slug')
            ->add('author')
            ->add('isEnable', null, ['editable' => true]);
    }

    public function prePersist($object)
    {
        $this->setTemplateForCollections($object);
    }

    public function preUpdate($object)
    {
        $this->setTemplateForCollections($object);
    }

    private function setTemplateForCollections($object)
    {
        foreach ($object->getStyles() as $image) {
            $image->setTemplate($object);
        }

        foreach ($object->getScripts() as $image) {
            $image->setTemplate($object);
        }

        foreach ($object->getImages() as $image) {
            $image->setTemplate($object);
        }
    }
}
