<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class Extension extends Admin
{
    protected $translationDomain = 'AppBundle';

    protected $datagridValues = [
        '_sort_by' => 'name',
        'createdAt'  => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt'  => ['type' => DateType::TYPE_GREATER_THAN]
    ];

    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name')
            ->add('fields', 'sonata_type_collection', [
                'required' => true
            ], [
                'edit'     => 'inline',
                'inline'   => 'table',
                'sortable' => 'position',
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('createdAt', 'doctrine_orm_datetime', [
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ])
            ->add('updatedAt', 'doctrine_orm_datetime', [
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
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
        foreach ($object->getFields() as $field) {
            $field->setExtension($object);
        }
    }
}
