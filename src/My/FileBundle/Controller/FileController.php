<?php

namespace My\FileBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use My\BackendBundle\Controller\CRUDInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\FileBundle\Entity\File;
use My\FileBundle\Form\FileType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class FileController extends CRUDController implements CRUDInterface
{
    public function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyFileBundle:File')
            ->getFilesQB($params['order'], $params['sequence'], $params['filter'], $params['groupId']);
    }

    public function getListTemplate()
    {
        return 'MyFileBundle:File:_list.html.twig';
    }

    public function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyFileBundle:File')
            ->find($id);
    }

    public function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyFileBundle:File')
            ->getFilesByIds($ids);
    }

    public function getNewEntity($params)
    {
        return new File($this->getUser());
    }

    public function getForm($entity, $params)
    {
        return $this->createForm(new FileType(), $entity, ['menuId' => $params['menuId']]);
    }

    public function getNewFormTemplate()
    {
        return 'MyFileBundle:File:_new.html.twig';
    }

    public function getEditFormTemplate()
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

        $em = $this->getDoctrine()->getManager();

        $entity = $this->getDoctrine()->getRepository('MyFileBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $view = $this->renderView('MyFileBundle:File:_info.html.twig', compact('entity'));

        $response = [
                "response" => true,
                "view"     => $view
                ];

        return new Response(json_encode($response));
    }
}
