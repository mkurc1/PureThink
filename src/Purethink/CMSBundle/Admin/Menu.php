<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Menu extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('slug', null, ['required' => false])
                ->add('article')
                ->add('language')
                ->add('type')
                ->add('sequence')
                ->add('menu')
                ->add('isPublic')
                ->add('isNewPage')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('slug')
            ->add('type')
            ->add('article')
            ->add('language')
            ->add('isPublic')
            ->add('isNewPage');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('slug')
            ->add('type')
            ->add('menu')
            ->add('sequence', null, ['editable' => true])
            ->add('article')
            ->add('language')
            ->add('isPublic', null, ['editable' => true])
            ->add('isNewPage', null, ['editable' => true]);
    }

}
