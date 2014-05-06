<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Menu extends Admin
{
    protected $parentAssociationMapping = 'type';

    protected $datagridValues = [
        '_sort_by' => 'name'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('article', 'sonata_type_model_list', [
                    'btn_add' => false
                ])
                ->add('language')
                ->add('sequence')
                ->add('menu', 'sonata_type_model_list', [
                    'required' => false,
                    'btn_add' => false
                ])
                ->add('isPublic')
                ->add('isNewPage')
            ->end()
            ->with('Set only when needed')
                ->add('slug', null, ["required" => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('slug')
            ->add('article')
            ->add('language')
            ->add('isPublic')
            ->add('isNewPage');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('slug')
            ->add('menu')
            ->add('sequence', null, ['editable' => true])
            ->add('article')
            ->add('language')
            ->add('isPublic', null, ['editable' => true])
            ->add('isNewPage', null, ['editable' => true]);
    }

}
