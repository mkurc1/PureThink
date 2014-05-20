<?php
namespace Purethink\CMSBundle\Admin;

use Purethink\CMSBundle\Entity\PositionComponent;
use Purethink\CMSBundle\Entity\PositionMenuType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Position extends Admin
{
    protected $parentAssociationMapping = 'layout';

    protected $datagridValues = [
        '_sort_by' => 'slug'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        $formMapper
            ->with('General')
            ->add('path', null, ['required' => false])
        ;

        if ($subject instanceof PositionMenuType) {
            $formMapper->add('menuType');
        }

        if ($subject instanceof PositionComponent) {
            $formMapper->add('component');
        }

        $formMapper->end();

        if ($subject->getSlug())
        $formMapper
            ->with('Set only when needed')
                ->add('slug', null, ["required" => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('layout')
            ->add('layout.template');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('slug')
            ->add('name')
            ->add('type')
            ->add('layout')
            ->add('layout.template')
            ->add('path');
    }

}
