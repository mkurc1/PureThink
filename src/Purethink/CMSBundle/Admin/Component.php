<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class Component extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'name'
    ];

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            "Component",
            ['uri' => $admin->generateUrl('edit', compact('id'))]
        );

        $menu->addChild(
            "Elements",
            ['uri' => $admin->generateUrl('purethink_cms.admin.componenthaselement.list', compact('id'))]
        );

    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('slug', null, ['required' => false])
                ->add('isEnable')
                ->add('language')
                ->add('extension')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('slug')
            ->add('extension')
            ->add('language')
            ->add('isEnable')
            ->add('createdAt')
            ->add('updatedAt');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier("slug")
            ->add('extension')
            ->add('language')
            ->add('isEnable', null, ['editable' => true])
            ->add("createdAt")
            ->add('updatedAt');
    }

    public function prePersist($object)
    {
        $this->setExtensionForCollections($object);
    }

    public function preUpdate($object)
    {
        $this->setExtensionForCollections($object);
    }

    private function setExtensionForCollections($object)
    {
        foreach ($object->getElements() as $image) {
            $image->setComponent($object);
        }
    }
}
