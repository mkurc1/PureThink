<?php

namespace My\CMSBundle\Form;

use My\CMSBundle\Entity\ComponentOnPageHasValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class ComponentOnPageHasValueType extends AbstractType
{
    private $componentOnPageHasValue = null;

    public function __construct(ComponentOnPageHasValue $componentOnPageHasValue = null)
    {
        $this->componentOnPageHasValue = $componentOnPageHasValue;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $extensionHasField = $this->componentOnPageHasValue->getExtensionHasField();

        $type = strtolower($extensionHasField->getTypeOfFieldString());
        $class = $extensionHasField->getClass();
        $label = $extensionHasField->getLabelOfField();
        $required = $extensionHasField->getIsRequired() ? [new NotNull()] : null;

        switch ($type) {
            case 'article':
                $type = 'entity';
                $entityClass = 'MyCMSBundle:Article';
                break;
            case 'file':
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
                    'selected_id' => $this->componentOnPageHasValue->getContent()
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

        if (null != $this->componentOnPageHasValue) {
            $builder->setData($this->componentOnPageHasValue);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\ComponentOnPageHasValue'
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_componentonpagehasvalue';
    }
}
