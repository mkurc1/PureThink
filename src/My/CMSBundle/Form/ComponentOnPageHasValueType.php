<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ComponentOnPageHasValueType extends AbstractType
{
    private $column = null;

    public function __construct($column = null)
    {
        $this->column = $column;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $options['type'];
        $isRequired = $options['isRequired'];
        $class = null;
        $required = null;

        switch ($type) {
            case 'Article':
                $type = 'entity';
                $class = 'MyCMSBundle:Article';
                if ($isRequired) {
                    $required = [new NotNull()];
                }
                break;
            case 'File':
                $type = 'entity';
                $class = 'MyFileBundle:File';
                if ($isRequired) {
                    $required = [new NotNull()];
                }
                break;
            default:
                $type = strtolower($type);
                if ($isRequired) {
                    $required = [new NotBlank()];
                }
        }

        if ($type == 'entity') {
            $builder->add('content', $type, [
                'required'    => $isRequired,
                'label'       => $options['label'],
                'class'       => $class,
                'empty_value' => '',
                'attr'        => [
                    'class'       => $options['class'],
                    'selected_id' => $this->column->getContent()
                ],
                'constraints' => $required
            ]);
        } else {
            $builder->add('content', $type, [
                'required'    => $isRequired,
                'label'       => $options['label'],
                'attr'        => ['class' => $options['class']],
                'constraints' => $required
            ]);
        }

        if (!is_null($this->column)) {
            $builder->setData($this->column);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'My\CMSBundle\Entity\ComponentOnPageHasValue',
            'class'      => null,
            'type'       => null,
            'label'      => null,
            'isRequired' => null
        ]);
    }

    public function getName()
    {
        return 'my_cmsbundle_componentonpagehasvalue';
    }
}
