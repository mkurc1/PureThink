<?php

namespace Purethink\CMSBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ArticleAdminController extends CRUDController
{
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $datagrid = $this->admin->getDatagrid();
        if ($category = $request->get('category')) {
            $datagrid->setValue('category', null, $category);
        }

        $formView = $datagrid->getForm()->createView();

        $categories = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Category')->findAll();

        /** @var FormExtension $form */
        $form = $this->get('twig')->getExtension('form');
        $form->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), [
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'categories' => $categories,
            'csrf_token' => $this->getCsrfToken('sonata.batch')
        ]);
    }
}