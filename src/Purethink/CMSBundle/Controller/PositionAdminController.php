<?php

namespace Purethink\CMSBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PositionAdminController extends CRUDController
{
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        if ($this->getRequest()->query->get('layout')) {
            $datagrid->setValue('layout', null, $this->getRequest()->query->get('layout'));
        }

        $formView = $datagrid->getForm()->createView();

        $layouts = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Layout')->findBy(['template' => $this->getRequest()->attributes->get('id')]);

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), [
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'layouts'       => $layouts,
            'csrf_token' => $this->getCsrfToken('sonata.batch')
        ]);
    }
}