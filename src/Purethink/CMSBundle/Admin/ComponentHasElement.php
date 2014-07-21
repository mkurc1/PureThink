<?php
namespace Purethink\CMSBundle\Admin;

use Purethink\CMSBundle\Entity\ComponentHasArticle;
use Purethink\CMSBundle\Entity\ComponentHasFile;
use Purethink\CMSBundle\Entity\ComponentHasText;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Purethink\CMSBundle\Entity\ComponentHasElement as Element;
use Purethink\CMSBundle\Entity\ExtensionHasField as Field;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pix\SortableBehaviorBundle\Services\PositionHandler;

class ComponentHasElement extends Admin
{
    protected $translationDomain = 'PurethinkCMSBundle';

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

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    );

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
        ComponentHasValue::$adminCollection = 0;

        $formMapper
            ->with('General')
                ->add('componentHasValues', 'sonata_type_collection', [
                    'label'        => false,
                    'btn_add'      => false,
                    'type_options' => [ 'delete' => false ]
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
            ['PurethinkCMSBundle:Form:admin.componentHasValues.html.twig']
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('enabled');
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
            ->add('created')
            ->add('updated')
            ->add('enabled', null, ['editable' => true])
            ->add('_action', 'actions', [
                'actions' => [
                    'move' => ['template' => 'PurethinkCMSBundle:Admin:_sort.html.twig'],
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
