<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Purethink\CMSBundle\Entity\ComponentHasElement as ComponentHasElementEntity;
use Purethink\CMSBundle\Entity\Component as ComponentEntity;

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
                ->add('language')
                ->add('extension')
                ->add('enabled')
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
            ->add('extension')
            ->add('language')
            ->add('enabled')
            ->add('created')
            ->add('updated');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier("slug")
            ->add('extension')
            ->add('language')
            ->add('enabled', null, ['editable' => true])
            ->add("created")
            ->add('updated');
    }

    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    public function preUpdate($object)
    {
        $this->setExtensionForCollections($object);
    }

    /** @var ComponentEntity $object */
    private function setExtensionForCollections($object)
    {
        /** @var ComponentHasElementEntity $element */
        foreach ($object->getElements() as $element) {
            $element->setComponent($object);
        }
    }
}
