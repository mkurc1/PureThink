<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ComponentHasElement extends Admin
{
    protected $parentAssociationMapping = 'component';


//    protected function configureFormFields(FormMapper $formMapper)
//    {
//        $formMapper
//            ->with('General')
//                ->add('isEnable')
//                ->add('componentHasValues', 'collection', ['type' => new ComponentHasValueType()])
//            ->end();
//    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('isEnable');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('isEnable', null, ['editable' => true]);
    }

    public function getNewInstance()
    {
        $element = parent::getNewInstance();
        $element->setComponent($this->getParentObject());

        return $element;
    }

    protected function getParentObject()
    {
        return $this->getParent()->getObject($this->getParent()->getRequest()->get('id'));
    }
}
