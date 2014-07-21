<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Purethink\CMSBundle\Entity\Layout as TemplateLayout;

class Layout extends Admin
{
    protected $translationDomain = 'PurethinkCMSBundle';

    protected $parentAssociationMapping = 'template';

    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('type', 'choice', [
                    'choices' => TemplateLayout::$availableType
                ])
                ->add('path')
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
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('type', 'doctrine_orm_number', [], 'choice', ['choices' => TemplateLayout::$availableType]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('stringType', null, ['label' => 'Name'])
            ->add('path');
    }

    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    public function preUpdate($object)
    {
        foreach ($object->getStyles() as $image) {
            $image->setLayout($object);
        }

        foreach ($object->getScripts() as $image) {
            $image->setLayout($object);
        }
    }
}
