<?php

namespace Purethink\CMSBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PositionAdminController extends CRUDController
{
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $datagrid = $this->admin->getDatagrid();
        if ($layout = $request->query->get('layout')) {
            $datagrid->setValue('layout', null, $layout);
        }

        $formView = $datagrid->getForm()->createView();

        $layouts = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Layout')
            ->findBy(['template' => $request->attributes->get('id')]);

        /** @var FormExtension $form */
        $form = $this->get('twig')->getExtension('form');
        $form->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), [
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'layouts'    => $layouts,
            'csrf_token' => $this->getCsrfToken('sonata.batch')
        ]);
    }
}