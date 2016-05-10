<?php
namespace AppBundle\Admin;

use AppBundle\Service\Language;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class SiteAdmin extends Admin
{
    /** @var Language */
    private $language;

    protected $formOptions = [
        'cascade_validation' => true,
        'validation_groups'  => ['site', 'default']
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('delete');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.general', ['class' => 'col-md-8'])
            ->add('translations', 'a2lix_translations', [
                'label'          => false,
                'locales'        => $this->language->getAvailableLocales(),
                'fields'         => [
                    'title'       => [
                        'label' => 'admin.metadata.title',
                    ],
                    'description' => [
                        'field_type' => 'textarea',
                        'label'      => 'admin.metadata.description'
                    ],
                    'keyword'     => [
                        'field_type' => 'textarea',
                        'label'      => 'admin.metadata.keyword'
                    ]
                ],
                'exclude_fields' => ['createdAt', 'updatedAt', 'deletedAt']
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'admin.id'
            ])
            ->add('translations.title', null, [
                'label' => 'admin.site.title'
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'admin.id'
            ])
            ->addIdentifier('title', null, [
                'label' => 'admin.site.title'
            ]);
    }

    public function setLanguageService(Language $language)
    {
        $this->language = $language;
    }
}
