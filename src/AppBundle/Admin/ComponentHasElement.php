<?php
namespace AppBundle\Admin;

use AppBundle\Entity\ComponentHasArticle;
use AppBundle\Entity\ComponentHasFile;
use AppBundle\Entity\ComponentHasText;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\ComponentHasElement as Element;
use AppBundle\Entity\ExtensionHasField as Field;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pix\SortableBehaviorBundle\Services\PositionHandler;
use Sonata\AdminBundle\Form\Type\Filter\DateType;

class ComponentHasElement extends Admin
{
    protected $translationDomain = 'AppBundle';

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
        'createdAt'     => ['type' => DateType::TYPE_GREATER_THAN],
        'updatedAt'     => ['type' => DateType::TYPE_GREATER_THAN]
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
            ->with('General', ['class' => 'col-md-6'])
            ->add('componentHasValues', 'sonata_type_collection', [
                'label'        => false,
                'btn_add'      => false,
                'type_options' => ['delete' => false]
            ], [
                'sortable' => 'position'
            ])
            ->add('enabled')
            ->end();
    }

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            [':Form:admin.componentHasValues.html.twig']
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
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
        if ($this->getParentObject()) {
            $this->last_position = $this->getParentObject()->getElements()->count() - 1;
        }

        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('position', null, ['editable' => true])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('enabled', null, ['editable' => true])
            ->add('_action', 'actions', [
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

    private function getComponentHasValueType(Element $entity, Field $field)
    {
        switch ($field->getTypeOfField()) {
            case Field::TYPE_ARTICLE:
                return new ComponentHasArticle($entity, $field);
                break;
            case Field::TYPE_FILE:
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
