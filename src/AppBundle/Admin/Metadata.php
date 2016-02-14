<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class Metadata extends Admin
{
    protected $translationDomain = 'AppBundle';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, ['required' => false])
            ->add('description', 'textarea', ['required' => false])
            ->add('keyword', 'textarea', ['required' => false]);
    }
}
