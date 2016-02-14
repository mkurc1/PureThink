<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class MetadataAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, [
                'label'    => 'admin.metadata.title',
                'required' => false
            ])
            ->add('description', 'textarea', [
                'label'    => 'admin.metadata.description',
                'required' => false
            ])
            ->add('keyword', 'textarea', [
                'label'    => 'admin.metadata.keyword',
                'required' => false
            ]);
    }
}
