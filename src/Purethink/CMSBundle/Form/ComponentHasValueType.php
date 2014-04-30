<?php

namespace Purethink\CMSBundle\Form;

use Purethink\CMSBundle\Entity\ComponentHasValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class ComponentHasValueType extends AbstractType
{
    private $componentHasValue;

    public function __construct(ComponentHasValue $componentHasValue = null)
    {
        $this->componentHasValue = $componentHasValue;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $this->componentHasValue->getExtensionHasField();

        $builder->add('content', $field->getTypeOfFieldString(), [
            'required'    => $field->getIsRequired(),
            'label'       => $field->getLabelOfField(),
            'attr'        => ['class' => $field->getClass()],
            'constraints' => $field->getIsRequired() ? [new NotNull()] : null
        ]);

        if ($this->componentHasValue) {
            $builder->setData($this->componentHasValue);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Purethink\CMSBundle\Entity\ComponentHasValue'
        ]);
    }

    public function getName()
    {
        return 'purethink_cmsbundle_componentonpagehasvalue';
    }
}
