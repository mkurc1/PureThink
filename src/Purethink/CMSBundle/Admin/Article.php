<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class Article extends Admin
{
    public $supportsPreviewMode = true;

    private $securityContext;

    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected $datagridValues = [
        '_sort_by' => 'name'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-8'])
                ->add('name')
                ->add('content', 'ckeditor', ['config_name' => 'default'])
                ->add('excerpt', 'ckeditor', ['config_name' => 'excerpt'])
            ->with('Setting', ['class' => 'col-md-4'])
                ->add('user', 'sonata_type_model_list', [
                    'btn_add' => false,
                    'btn_delete' => false
                ])
                ->add('language')
                ->add('category', 'sonata_type_model_list', [
                    'btn_delete' => false
                ])
                ->add('tags', 'sonata_type_model', [
                    'required' => false,
                    'multiple' => true
                ])
                ->add('published')
                ->add('slug', null, ["required" => false])
            ->end()
            ->with('SEO', ['class' => 'col-md-4'])
                ->add('metadata', 'sonata_type_admin', [
                    'label' => false,
                    'delete' => false,
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
            ->add('created')
            ->add('updated')
            ->add('category', 'doctrine_orm_callback', [
                'callback' => function($queryBuilder, $alias, $field, $value) {
                    if (!$value || !$value['value']) {
                        return false;
                    } else {
                        $queryBuilder->andWhere($alias . '.category = :category');
                        $queryBuilder->setParameter('category', $value['value']);

                        return true;
                    }
                }
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier("slug")
            ->add("category")
            ->add('user')
            ->add('view.views', null, ['label' => 'Views'])
            ->add('published', null, ['editable' => true])
            ->add("created")
            ->add('updated');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('language')
            ->add('content', null, ['safe' => true])
            ->add('tags')
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
