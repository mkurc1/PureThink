<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class Article extends Admin
{
    public $supportsPreviewMode = true;

    private $securityContext;

    protected $translationDomain = 'AppBundle';

    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected $datagridValues = [
        '_sort_by'  => 'name',
        'createdAt' => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt' => ['type' => DateType::TYPE_GREATER_THAN]
    ];


    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-8'])
            ->add('name')
            ->add('content', 'ckeditor', ['config_name' => 'default'])
            ->add('excerpt', 'ckeditor', ['config_name' => 'excerpt'])
            ->end()
            ->with('Options', ['class' => 'col-md-4'])
            ->add('user', 'sonata_type_model_list', [
                'btn_add'    => false,
                'btn_delete' => false
            ])
            ->add('language')
            ->add('published')
            ->add('slug', null, ["required" => false])
            ->end()
            ->with('SEO', ['class' => 'col-md-4'])
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
            ->add('id')
            ->add('name')
            ->add('slug')
            ->add('user')
            ->add('createdAt', 'doctrine_orm_datetime', [
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ])
            ->add('updatedAt', 'doctrine_orm_datetime', [
                'field_type'    => 'sonata_type_datetime_picker',
                'field_options' => [
                    'format' => 'dd MMM yyyy, HH:mm',
                ]
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier("slug")
            ->add('user')
            ->add('view.views', null, ['label' => 'Views'])
            ->add('published', null, ['editable' => true])
            ->add("createdAt")
            ->add('updatedAt');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('language')
            ->add('content', null, ['safe' => true])
            ->add('published');
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
}
