<?php
namespace Purethink\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class TemplateStyle extends Admin
{
    protected $translationDomain = 'PurethinkCMSBundle';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('path');
    }
}
