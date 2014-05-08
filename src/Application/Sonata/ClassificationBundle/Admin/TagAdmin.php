<?php

namespace Application\Sonata\ClassificationBundle\Admin;

use Application\Sonata\ClassificationBundle\Entity\Tag;
use Sonata\ClassificationBundle\Admin\TagAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TagAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper->add('name');

        if ($this->hasSubject() && $this->getSubject()->getId()) {
            $formMapper->add('slug');
        }

        $formMapper
            ->add('color', 'choice', ['choices' => Tag::$colors, 'label' => 'Color'])
            ->add('enabled', null, array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('color', 'doctrine_orm_string', ['label' => 'Color'], 'choice', ['choices' => Tag::$colors])
            ->add('enabled')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('slug')
            ->add('colorString', null, ['label' => 'Color'])
            ->add('enabled', null, ['editable' => true])
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
