<?php
namespace AppBundle\Admin;

use AppBundle\Entity\ComponentHasArticle;
use AppBundle\Entity\ComponentHasFile;
use AppBundle\Entity\ComponentHasText;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\ComponentHasElement;
use AppBundle\Entity\ExtensionHasField;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pix\SortableBehaviorBundle\Services\PositionHandler;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class ComponentHasElementAdmin extends Admin
{
    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected $parentAssociationMapping = 'component';

    public $last_position = 0;

    private $container;
    /** @var PositionHandler */
    private $positionService;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'ASC',
        '_sort_by'    => 'position',
        'createdAt'   => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt'   => ['type' => DateType::TYPE_GREATER_THAN]
    ];

    public function setPositionService(PositionHandler $positionHandler)
    {
        $this->positionService = $positionHandler;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('move', $this->getRouterIdParameter() . '/move/{position}');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.general', ['class' => 'col-md-6'])
            ->add('componentHasValues', 'sonata_type_collection', [
                'label'        => false,
                'btn_add'      => false,
                'type_options' => [
                    'delete'  => false,
                    'btn_add' => false,
                    'label'   => false
                ]
            ], [
                'sortable' => 'position'
            ])
            ->add('enabled', null, [
                'label' => 'admin.component_has_element.enabled'
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'admin.id'
            ])
            ->add('enabled', null, [
                'label' => 'admin.component_has_element.enabled'
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
        if ($this->getParentObject()) {
            $this->last_position = $this->getParentObject()->getElements()->count() - 1;
        }

        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'admin.id'
            ])
            ->addIdentifier('title', null, [
                'label' => 'admin.component_has_element.title'
            ])
            ->add('position', null, [
                'label'    => 'admin.component_has_element.position',
                'editable' => true
            ])
            ->add('createdAt', null, [
                'label' => 'admin.created_at'
            ])
            ->add('updatedAt', null, [
                'label' => 'admin.updated_at'
            ])
            ->add('enabled', null, [
                'label'    => 'admin.component_has_element.enabled',
                'editable' => true
            ])
            ->add('_action', 'actions', [
                'label'   => 'admin.actions',
                'actions' => [
                    'move' => ['template' => ':Admin:_sort.html.twig'],
                ]
            ]);
    }

    public function getNewInstance()
    {
        $element = parent::getNewInstance();
        $element->setComponent($this->getParentObject());

        $fields = $element->getComponent()->getExtension()->getFields();
        foreach ($fields as $field) {
            $componentHasValue = $this->getComponentHasValueType($element, $field);
            $element->addComponentHasValue($componentHasValue);
        }

        return $element;
    }

    private function getComponentHasValueType(ComponentHasElement $entity, ExtensionHasField $field)
    {
        switch ($field->getTypeOfField()) {
            case ExtensionHasField::TYPE_ARTICLE:
                return new ComponentHasArticle($entity, $field);
                break;
            case ExtensionHasField::TYPE_FILE:
                return new ComponentHasFile($entity, $field);
                break;
            default:
                return new ComponentHasText($entity, $field);
        }
    }

    protected function getParentObject()
    {
        if ($this->getParent()) {
            return $this->getParent()->getObject($this->getParent()->getRequest()->get('id'));
        }

        return null;
    }
}
