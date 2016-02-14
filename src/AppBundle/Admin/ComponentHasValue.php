<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotNull;
use AppBundle\Entity\ComponentHasValue as ComponentHasValueEntity;
use Doctrine\Common\Collections\ArrayCollection;

class ComponentHasValue extends Admin
{
    protected $translationDomain = 'AppBundle';

    public static $adminCollection = 0;

    protected $parentAssociationMapping = 'componentHasElement';


    private function getCurrentObjectFromCollection(ComponentHasValue $componentHasValue)
    {
        $parentFieldDescription = $componentHasValue->getParentFieldDescription();

        $getter = 'get' . $parentFieldDescription->getFieldName();
        $parent = $parentFieldDescription->getAdmin()->getSubject();

        /** @var ArrayCollection $collection */
        $collection = $parent->$getter();
        $collectionCount = $collection->count() - 1;

        $number = self::$adminCollection++;

        if ($number == $collectionCount) {
            self::$adminCollection = 0;
        }

        return $collection[$number];
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getCurrentObjectFromCollection($this);

        $this->setSubject($object);

        /** @var ComponentHasValueEntity $object */
        $field = $object->getExtensionHasField();

        $formMapper->add('content', $field->getTypeOfFieldString(), [
            'required'    => $field->getRequired(),
            'label'       => $field->getLabelOfField(),
            'attr'        => ['class' => $field->getClass()],
            'constraints' => $field->getRequired() ? [new NotNull()] : null
        ]);
    }
}
