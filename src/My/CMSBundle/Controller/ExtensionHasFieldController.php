<?php

namespace My\CMSBundle\Controller;

use My\BackendBundle\Controller\CRUDController;
use My\BackendBundle\Controller\CRUDInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\ExtensionHasField;
use My\CMSBundle\Form\ExtensionHasFieldType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/extension/field")
 */
class ExtensionHasFieldController extends CRUDController implements CRUDInterface
{
    public function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:ExtensionHasField')
            ->getFieldsQB($params['order'], $params['sequence'], $params['filter'], $params['sublistId']);
    }

    public function getListTemplate()
    {
        return 'MyCMSBundle:ExtensionHasField:_list.html.twig';
    }

    public function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:ExtensionHasField')
            ->find($id);
    }

    public function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:ExtensionHasField')
            ->getFieldsByIds($ids);
    }

    public function getNewEntity($params)
    {
        $extension = $this->getDoctrine()
            ->getRepository('MyCMSBundle:Extension')->find($params['sublistId']);

        return new ExtensionHasField($extension);
    }

    public function getForm($entity, $params)
    {
        return $this->createForm(new ExtensionHasFieldType(), $entity, ['menuId' => $params['menuId']]);
    }

    public function getNewFormTemplate()
    {
        return 'MyCMSBundle:ExtensionHasField:_new.html.twig';
    }

    public function getEditFormTemplate()
    {
        return 'MyCMSBundle:ExtensionHasField:_edit.html.twig';
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $selectedElement = $em->getRepository('MyCMSBundle:ExtensionHasField')->find($id);

        if (!$selectedElement) {
            throw $this->createNotFoundException();
        }

        $entities = $em->getRepository('MyCMSBundle:ExtensionHasField')
            ->findByExtension($selectedElement->getExtension());

        foreach ($entities as $entity) {
            if ($entity == $selectedElement) {
                $entity->setIsMainField(true);
            }
            else {
                $entity->setIsMainField(false);
            }
        }

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message"  => 'Zmiana domyślnej kolumny zakończyła się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => 'Zmiana domyślnej kolumny zakończyła się niepowodzeniem'
                );
        }

        return new Response(json_encode($response));
    }
}
