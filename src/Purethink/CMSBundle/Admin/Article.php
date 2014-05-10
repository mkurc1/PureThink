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
            ->with('General')
                ->add('name')
                ->add('language')
                ->add('content', 'ckeditor')
                ->add('tags', 'sonata_type_model', [
                    'required' => false,
                    'multiple' => true
                ])
                ->add('isPublic')
            ->with('SEO')
                ->add('metadata', 'sonata_type_admin', [
                    'label' => false,
                    'delete' => false,
                    'btn_add' => false
                ])
            ->end()
            ->with('Set only when needed')
                ->add('slug', null, ["required" => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier("slug")
            ->add('isPublic', null, ['editable' => true])
            ->add("createdAt")
            ->add('updatedAt');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('language')
            ->add('content', null, ['safe' => true])
            ->add('tags')
            ->add('isPublic');
    }

    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    protected function getSecurityContext()
    {
        return $this->securityContext;
    }

    public function prePersist($article)
    {
        $user = $this->getSecurityContext()->getToken()->getUser();
        $article->setUser($user);
    }
}
