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

class ComponentHasElement extends Admin
{
    protected $formOptions = [
        'cascade_validation' => true
    ];

    protected $parentAssociationMapping = 'component';


    protected function configureFormFields(FormMapper $formMapper)
    {
        ComponentHasValue::$adminCollection = 0;

        $formMapper
            ->with('General')
                ->add('isEnable')
                ->add('componentHasValues', 'sonata_type_collection', [
                    'label'        => false,
                    'btn_add'      => false,
                    'type_options' => [ 'delete' => false ]
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('isEnable');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('isEnable', null, ['editable' => true]);
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
        return $this->getParent()->getObject($this->getParent()->getRequest()->get('id'));
    }
}
