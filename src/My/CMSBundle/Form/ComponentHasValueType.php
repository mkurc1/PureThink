<?php

namespace My\CMSBundle\Form;

use My\CMSBundle\Entity\ComponentHasValue;
use My\CMSBundle\Entity\ExtensionHasField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class ComponentHasValueType extends AbstractType
{
    private $componentHasValue = null;

    public function __construct(ComponentHasValue $componentHasValue = null)
    {
        $this->componentHasValue = $componentHasValue;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $extensionHasField = $this->componentHasValue->getExtensionHasField();

        $type = null;
        $class = $extensionHasField->getClass();
        $label = $extensionHasField->getLabelOfField();
        $required = $extensionHasField->getIsRequired() ? [new NotNull()] : null;

        switch ($extensionHasField->getTypeOfField()) {
            case ExtensionHasField::TYPE_ARTICLE:
                $type = 'entity';
                $entityClass = 'MyCMSBundle:Article';
                break;
            case ExtensionHasField::TYPE_FILE:
                $type = 'entity';
                $entityClass = 'MyFileBundle:File';
                break;
        }

        if ($type == 'entity') {
            $builder->add('content', $type, [
                'required'    => false,
                'label'       => $label,
                'class'       => $entityClass,
                'empty_value' => '',
                'attr'        => [
                    'class'       => $class,
                ],
                'constraints' => $required
            ]);
        } else {
            $builder->add('content', $type, [
                'required'    => false,
                'label'       => $label,
                'attr'        => ['class' => $class],
                'constraints' => $required
            ]);
        }

        if (null != $this->componentHasValue) {
            $builder->setData($this->componentHasValue);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\ComponentHasValue'
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_componentonpagehasvalue';
    }
}
