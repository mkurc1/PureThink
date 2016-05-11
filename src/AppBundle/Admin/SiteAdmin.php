<?php
namespace AppBundle\Admin;

use AppBundle\Service\Language;
use Sonata\AdminBundle\Admin\Admin;
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
            ->remove('show')
            ->remove('create')
            ->remove('batch')
            ->remove('export')
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
            ->end()
            ->with('admin.options', ['class' => 'col-md-4'])
            ->add('trackingCode', 'textarea', [
                'label'    => 'admin.site.tracking_code',
                'required' => false,
                'attr'     => [
                    'rows' => 6
                ]
            ])
            ->end();
    }

    public function setLanguageService(Language $language)
    {
        $this->language = $language;
    }
}
