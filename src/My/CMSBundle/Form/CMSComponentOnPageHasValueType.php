<?php

namespace My\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CMSComponentOnPageHasValueType extends AbstractType
{
    private $column = null;

    public function __construct($column = null)
    {
        $this->column = $column;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $options['attr']['type'];
        $class = null;

        switch ($type) {
            case 'Article':
                $type = 'entity';
                $class = 'MyCMSBundle:CMSArticle';
                break;
            case 'File':
                $type = 'entity';
                $class = 'MyFileBundle:File';
                break;
            default:
                $type = strtolower($type);
                break;
        }

        if ($type == 'entity') {
            $builder->add('content', $type, array(
                'label' => $options['attr']['label'],
                'class' => $class,
                'empty_value' => '',
                'attr' => array(
                    'class' => $options['attr']['class']
                    ),
                )
            );
        }
        else {
            $builder->add('content', $type, array(
                'label' => $options['attr']['label'],
                'attr' => array(
                    'class' => $options['attr']['class']
                    ),
                )
            );
        }

        if (!is_null($this->column)) {
            $builder->setData($this->column);
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\CMSBundle\Entity\CMSComponentOnPageHasValue'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'my_cmsbundle_cmscomponentonpagehasvalue';
    }
}
