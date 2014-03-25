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
        $type = $options['attr']['type'];
        $isRequired = $options['attr']['isRequired'];
        $class = null;
        $required = null;

        switch ($type) {
            case 'Article':
                $type = 'entity';
                $class = 'MyCMSBundle:Article';
                if ($isRequired) {
                    $required = array(new NotNull());
                }
                break;
            case 'File':
                $type = 'entity';
                $class = 'MyFileBundle:File';
                if ($isRequired) {
                    $required = array(new NotNull());
                }
                break;
            default:
                $type = strtolower($type);
                if ($isRequired) {
                    $required = array(new NotBlank());
                }
                break;
        }

        if ($type == 'entity') {
            $builder->add('content', $type, array(
                'required' => $isRequired,
                'label' => $options['attr']['label'],
                'class' => $class,
                'empty_value' => '',
                'attr' => array(
                    'class' => $options['attr']['class'],
                    'selected_id' => $this->column->getContent()
                    ),
                'constraints' => $required
                )
            );
        }
        else {
            $builder->add('content', $type, array(
                'required' => $isRequired,
                'label' => $options['attr']['label'],
                'attr' => array(
                    'class' => $options['attr']['class']
                    ),
                'constraints' => $required
                )
            );
        }

        if (!is_null($this->column)) {
            $builder->setData($this->column);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\CMSBundle\Entity\ComponentOnPageHasValue'
        ));
    }

    public function getName()
    {
        return 'my_cmsbundle_componentonpagehasvalue';
    }
}
