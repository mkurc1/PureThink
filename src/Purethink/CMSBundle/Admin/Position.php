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
    protected $parentAssociationMapping = 'template';

    protected $datagridValues = [
        '_sort_by' => 'slug'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        $formMapper
            ->with('General')
                ->add('layout', null, ["query_builder" => $this->getLayoutsQb()])
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
            ->add('layout', 'doctrine_orm_callback', [
                'callback' => function($queryBuilder, $alias, $field, $value) {
                    if (!$value || !$value['value']) {
                        return false;
                    } else {
                        $queryBuilder->leftJoin(sprintf('%s.layout', $alias), 'l');
                        $queryBuilder->andWhere('l.id = :layout');
                        $queryBuilder->setParameter('layout', $value['value']);

                        return true;
                    }
                }
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('slug')
            ->add('name')
            ->add('type')
            ->add('layout')
            ->add('path');
    }

    protected function getLayoutsQb()
    {
        return $this->modelManager
            ->getEntityManager('PurethinkCMSBundle:Layout')
            ->getRepository('PurethinkCMSBundle:Layout')
            ->getLayoutsQb($this->getSubject()->getTemplate());
    }
}
