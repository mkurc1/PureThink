<?php

namespace AppBundle\Form\Type;

use Sonata\AdminBundle\Form\Type\AdminType as BaseAdminType;
use Sonata\AdminBundle\Form\DataTransformer\ArrayToModelTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class AdminType extends BaseAdminType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $admin = clone $this->getAdmin($options);

        if ($admin->hasParentFieldDescription()) {
            $admin->getParentFieldDescription()->setAssociationAdmin($admin);
        }

        if ($options['delete'] && $admin->isGranted('DELETE')) {
            if (!array_key_exists('translation_domain', $options['delete_options']['type_options'])) {
                $options['delete_options']['type_options']['translation_domain'] = $admin->getTranslationDomain();
            }

            $builder->add('_delete', $options['delete_options']['type'], $options['delete_options']['type_options']);
        }

        // hack to make sure the subject is correctly set
        // https://github.com/sonata-project/SonataAdminBundle/pull/2076
        if ($builder->getData() === null) {
            $p = new PropertyAccessor(false, true);
            try {
                $subject = $p->getValue(
                    $admin->getParentFieldDescription()->getAdmin()->getSubject(),
                    $this->getFieldDescription($options)->getFieldName() . $options['property_path']
                );
                $builder->setData($subject);
            } catch (NoSuchIndexException $e) {
                // no object here
            }
        }

        $admin->setSubject($builder->getData());

        $admin->defineFormBuilder($builder);

        $builder->addModelTransformer(new ArrayToModelTransformer($admin->getModelManager(), $admin->getClass()));
    }
}