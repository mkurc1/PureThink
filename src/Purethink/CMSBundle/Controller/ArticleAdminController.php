<?php

namespace Purethink\CMSBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ArticleAdminController extends CRUDController
{
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        if ($this->getRequest()->query->get('category')) {
            $datagrid->setValue('category', null, $this->getRequest()->query->get('category'));
        }

        $formView = $datagrid->getForm()->createView();

        $categories = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Category')->findAll();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), [
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'categories' => $categories,
            'csrf_token' => $this->getCsrfToken('sonata.batch')
        ]);
    }
}