<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use AppBundle\Entity\ComponentHasElement as ComponentHasElementEntity;
use AppBundle\Entity\Component as ComponentEntity;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class Component extends Admin
{
    protected $translationDomain = 'AppBundle';

    protected $datagridValues = [
        '_sort_by' => 'name',
        'createdAt'  => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt'  => ['type' => DateType::TYPE_GREATER_THAN]
    ];

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            $this->trans('Component'),
            ['uri' => $admin->generateUrl('edit', compact('id'))]
        );

        $menu->addChild(
            $this->trans('Elements'),
            ['uri' => $admin->generateUrl('app.admin.component_has_element.list', compact('id'))]
        );
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-8'])
            ->add('name')
            ->add('language')
            ->add('extension')
            ->add('enabled')
            ->end()
            ->with('Set only when needed', ['class' => 'col-md-4'])
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
            ->add('extension')
            ->add('language')
            ->add('enabled', null, ['editable' => true])
            ->add("createdAt")
            ->add('updatedAt');
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
