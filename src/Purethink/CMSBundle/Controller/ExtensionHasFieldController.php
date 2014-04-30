<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\ExtensionHasField;
use Purethink\CMSBundle\Form\ExtensionHasFieldType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/extension/field")
 */
class ExtensionHasFieldController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:ExtensionHasField')
            ->getFieldsQB($params['order'], $params['sequence'], $params['filter'], $params['sublistId']);
    }

    protected function getListTemplate()
    {
        return 'PurethinkCMSBundle:ExtensionHasField:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:ExtensionHasField')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:ExtensionHasField')
            ->getFieldsByIds($ids);
    }

    protected function getNewEntity($params)
    {
        $extension = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Extension')->find($params['sublistId']);

        return new ExtensionHasField($extension);
    }

    protected function getForm($entity, $params)
    {
        return $this->createForm(new ExtensionHasFieldType(), $entity, ['menuId' => $params['menuId']]);
    }

    protected function getNewFormTemplate()
    {
        return 'PurethinkCMSBundle:ExtensionHasField:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'PurethinkCMSBundle:ExtensionHasField:_edit.html.twig';
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $selectedElement = $em->getRepository('PurethinkCMSBundle:ExtensionHasField')->find($id);
        if (!$selectedElement) {
            throw $this->createNotFoundException();
        }

        $entities = $em->getRepository('PurethinkCMSBundle:ExtensionHasField')
            ->findByExtension($selectedElement->getExtension());

        foreach ($entities as $entity) {
            if ($entity == $selectedElement) {
                $entity->setIsMainField(true);
            } else {
                $entity->setIsMainField(false);
            }
        }

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
