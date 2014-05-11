<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class Template extends Admin
{
    protected $formOptions = [
        'cascade_validation' => true
    ];

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
            "Template",
            ['uri' => $admin->generateUrl('edit', compact('id'))]
        );

        $menu->addChild(
            "Layouts",
            ['uri' => $admin->generateUrl('purethink_cms.admin.layout.list', compact('id'))]
        );
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('author')
                ->add('icon')
                ->add('enabled')
            ->end()
            ->with('Style')
                ->add('styles', 'sonata_type_collection', [
                    'required' => false
                ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                ])
            ->end()
            ->with('Script')
                ->add('scripts', 'sonata_type_collection', [
                    'required' => false
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
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
            ->add('author')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('slug')
            ->add('author')
            ->add('enabled', null, ['editable' => true]);
    }

    public function prePersist($object)
    {
        $this->setTemplateForCollections($object);
    }

    public function preUpdate($object)
    {
        $this->setTemplateForCollections($object);
    }

    /**
     * @param \Purethink\CMSBundle\Entity\Template $object
     */
    private function setTemplateForCollections($object)
    {
        foreach ($object->getStyles() as $image) {
            $image->setTemplate($object);
        }

        foreach ($object->getScripts() as $image) {
            $image->setTemplate($object);
        }
    }
}
