<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Purethink\CMSBundle\Entity\Menu as Entity;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Menu extends Admin
{
    protected $translationDomain = 'PurethinkCMSBundle';

    protected $parentAssociationMapping = 'type';

    protected $datagridValues = [
        '_sort_by' => 'name'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-8'])
                ->add('name')
                ->add('typeOfLink', 'choice', [
                    'multiple' => false,
                    'expanded' => true,
                    'choices' => Entity::$linkTypes
                ])
                ->add('article', 'sonata_type_model_list', [
                    'btn_add' => false
                ])
                ->add('url', 'url', [
                    'required' => false
                ])
                ->add('menu', 'sonata_type_model_list', [
                        'required' => false,
                        'btn_add' => false
                    ])
            ->end()
            ->with('Options', ['class' => 'col-md-4'])
                ->add('language')
                ->add('published')
                ->add('isNewPage')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('article')
            ->add('language')
            ->add('published');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('menu')
            ->add('position', null, ['editable' => true])
            ->add('typeOfLink', 'choice', [
                'choices' => Entity::$linkTypes
            ])
            ->add('article')
            ->add('url')
            ->add('language')
            ->add('published', null, ['editable' => true])
            ->add('isNewPage', null, ['editable' => true]);
    }

}
