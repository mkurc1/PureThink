<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class Metadata extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, ['required' => false])
            ->add('description', 'textarea', ['required' => false])
            ->add('keyword', 'textarea', ['required' => false]);
    }
}
