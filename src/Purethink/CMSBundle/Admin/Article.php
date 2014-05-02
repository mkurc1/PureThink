<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class Article extends Admin
{
    private $securityContext;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('language')
                ->add('content', 'ckeditor')
                ->add('isPublic')
            ->with('SEO')
                ->add('slug', null, ['required' => false])
                ->add('metadata', 'metadata', ['required' => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier("slug")
            ->add('isPublic', null, ['editable' => true])
            ->add("createdAt")
            ->add('updatedAt');
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
