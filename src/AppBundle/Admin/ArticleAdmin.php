<?php
namespace AppBundle\Admin;

use AppBundle\Service\Language;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class ArticleAdmin extends Admin
{
    public $supportsPreviewMode = true;

    private $securityContext;

    /** @var Language */
    private $language;

    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected $datagridValues = [
        'createdAt' => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt' => ['type' => DateType::TYPE_GREATER_THAN]
    ];


    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('admin.general', ['class' => 'col-md-8'])
            ->add('translations', 'a2lix_translations', [
                'label'          => false,
                'locales'        => $this->language->getAvailableLocales(),
                'fields'         => [
                    'name'    => [
                        'label' => 'admin.article.name',
                    ],
                    'slug'    => [
                        'label' => 'admin.article.slug'
                    ],
                    'content' => [
                        'field_type'  => 'ckeditor',
                        'config_name' => 'default',
                        'label'       => 'admin.article.content'
                    ],
                    'excerpt' => [
                        'field_type'  => 'ckeditor',
                        'config_name' => 'excerpt',
                        'label'       => 'admin.article.excerpt'
                    ]
                ],
                'exclude_fields' => ['createdAt', 'updatedAt', 'deletedAt']
            ])
            ->end()
            ->with('admin.options', ['class' => 'col-md-4'])
            ->add('user', 'sonata_type_model_list', [
                'label'      => 'admin.article.user',
                'btn_add'    => false,
                'btn_delete' => false
            ])
            ->add('published', null, [
                'label' => 'admin.article.published'
            ])
            ->end()
            ->with('admin.seo', ['class' => 'col-md-4'])
            ->add('metadata', 'sonata_type_admin', [
                'label'   => false,
                'delete'  => false,
                'btn_add' => false
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'admin.id'
            ])
            ->add('translations.name', null, [
                'label' => 'admin.article.name'
            ])
            ->add('translations.slug', null, [
                'label' => 'admin.article.slug'
            ])
            ->add('user', null, [
                'label' => 'admin.article.user'
            ])
            ->add('createdAt', 'doctrine_orm_datetime', [
                'label'         => 'admin.created_at',
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ])
            ->add('updatedAt', 'doctrine_orm_datetime', [
                'label'         => 'admin.updated_at',
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'admin.id'
            ])
            ->addIdentifier('name', null, [
                'label' => 'admin.article.name'
            ])
            ->addIdentifier("slug", null, [
                'label' => 'admin.article.slug'
            ])
            ->add('user', null, [
                'label' => 'admin.article.user'
            ])
            ->add('view.views', null, [
                'label' => 'admin.article.views'
            ])
            ->add('published', null, [
                'editable' => true,
                'label'    => 'admin.article.published'
            ])
            ->add("createdAt", null, [
                'label' => 'admin.created_at'
            ])
            ->add('updatedAt', null, [
                'label' => 'admin.updated_at'
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, [
                'label' => 'admin.article.name'
            ])
            ->add('content', null, [
                'label' => 'admin.article.content',
                'safe'  => true
            ])
            ->add('published', null, [
                'label' => 'admin.article.published'
            ]);
    }

    public function getNewInstance()
    {
        $article = parent::getNewInstance();

        $user = $this->getSecurityContext()->getToken()->getUser();
        $article->setUser($user);

        return $article;
    }

    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    protected function getSecurityContext()
    {
        return $this->securityContext;
    }

    public function setLanguageService(Language $language)
    {
        $this->language = $language;
    }
}
