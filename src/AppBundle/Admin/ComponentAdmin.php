<?php
namespace AppBundle\Admin;

use AppBundle\Service\Language;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class ComponentAdmin extends Admin
{
    /** @var Language */
    private $language;
    
    protected $datagridValues = [
        '_sort_by'  => 'name',
        'createdAt' => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt' => ['type' => DateType::TYPE_GREATER_THAN]
    ];

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            $this->trans('admin.component.side_menu.component'),
            ['uri' => $admin->generateUrl('edit', compact('id'))]
        );

        $menu->addChild(
            $this->trans('admin.component.side_menu.elements'),
            ['uri' => $admin->generateUrl('app.admin.component_has_element.list', compact('id'))]
        );
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.general', ['class' => 'col-md-8'])
            ->add('translations', 'a2lix_translations', [
                'label'          => false,
                'locales'        => $this->language->getAvailableLocales(),
                'fields'         => [
                    'name'        => [
                        'label' => 'admin.component.name',
                    ]
                ],
                'exclude_fields' => ['createdAt', 'updatedAt', 'deletedAt']
            ])
            ->add('extension', null, [
                'label' => 'admin.component.extension'
            ])
            ->add('enabled', null, [
                'label' => 'admin.component.enabled'
            ])
            ->end()
            ->with('admin.options', ['class' => 'col-md-4'])
            ->add('slug', null, [
                'label'    => 'admin.component.slug',
                'required' => false
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
                'label' => 'admin.component.name'
            ])
            ->add('slug', null, [
                'label' => 'admin.component.slug'
            ])
            ->add('extension', null, [
                'label' => 'admin.component.extension'
            ])
            ->add('enabled', null, [
                'label' => 'admin.component.enabled'
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
                'label' => 'admin.component.name'
            ])
            ->addIdentifier("slug", null, [
                'label' => 'admin.component.slug'
            ])
            ->add('extension', null, [
                'label' => 'admin.component.extension'
            ])
            ->add('enabled', null, [
                'label'    => 'admin.component.enabled',
                'editable' => true
            ])
            ->add("createdAt", null, [
                'label' => 'admin.created_at'
            ])
            ->add('updatedAt', null, [
                'label' => 'admin.updated_at'
            ]);
    }

    public function setLanguageService(Language $language)
    {
        $this->language = $language;
    }
}
