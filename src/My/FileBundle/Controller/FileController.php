<?php

namespace My\FileBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\FileBundle\Entity\File;
use My\FileBundle\Form\FileType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class FileController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyFileBundle:File')
            ->getFilesQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'MyFileBundle:File:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyFileBundle:File')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyFileBundle:File')
            ->getFilesByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new File($this->getUser());
    }

    protected function getForm($entity, $params)
    {
        return $this->createForm(new FileType(), $entity, ['menuId' => $params['menuId']]);
    }

    protected function getNewFormTemplate()
    {
        return 'MyFileBundle:File:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'MyFileBundle:File:_edit.html.twig';
    }

    /**
     * @Route("/info", options={"expose"=true})
     * @Method("POST")
     */
    public function infoAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getEntity($id);
        $view = $this->renderView('MyFileBundle:File:_info.html.twig', compact('entity'));

        $response = [
            "response" => true,
            "view"     => $view
        ];

        return new Response(json_encode($response));
    }
}
