<?php

namespace My\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CRUDController extends Controller
{
    /**
     * @Route("/")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $params = [
            'rowsOnPage' => (int)$request->get('rowsOnPage', 10),
            'page'       => (int)$request->get('page', 1),
            'order'      => $request->get('order', 'a.name'),
            'sequence'   => $request->get('sequence', 'ASC'),
            'filter'     => $request->get('filtr', null),
            'languageId' => (int)$request->get('languageId'),
            'groupId'    => (int)$request->get('groupId'),
            'sublistId'  => (int)$request->get('sublistId')
        ];

        $entities   = $this->getListQB($params);
        $pagination = $this->setPagination($entities, $params['page'], $params['rowsOnPage']);

        $list = $this->renderView($this->getListTemplate(), [
            'entities'   => $pagination['entities'],
            'page'       => $params['page'],
            'rowsOnPage' => $params['rowsOnPage']
            ]);

        $response = [
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true
            ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $params = [
            'menuId'    => (int)$request->get('menuId'),
            'sublistId' => (int)$request->get('sublistId')
            ];

        $entity = $this->getNewEntity($params);
        $form = $this->getForm($entity, $params);

        $view = $this->renderView($this->getNewFormTemplate(), [
            'entity' => $entity,
            'form'   => $form->createView()
            ]);

        $response = [
            "response" => true,
            "view"     => $view
            ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $params = [
            'menuId'    => (int)$request->get('menuId'),
            'sublistId' => (int)$request->get('sublistId')
            ];

        $entity = $this->getNewEntity($params);
        $form = $this->getForm($entity, $params);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = [
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Dodawanie pozycji zakończyło się powodzeniem'
                ];
        }
        else {
            $view = $this->renderView($this->getNewFormTemplate(), [
                'entity' => $entity,
                'form'   => $form->createView()
                ]);

            $response = [
                "response" => false,
                "view"     => $view
                ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $params = [
            'menuId' => (int)$request->get('menuId')
            ];

        $entity = $this->getEntityById($id);
        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->getForm($entity, $params);

        $view = $this->renderView($this->getEditFormTemplate(), [
            'entity' => $entity,
            'form'   => $form->createView()
            ]);

        $response = [
            "response" => true,
            "view"     => $view
            ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $params = [
            'menuId' => (int)$request->get('menuId')
            ];

        $entity = $this->getEntityById($id);
        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->getForm($entity, $params);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $response = [
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Edycja pozycji zakończyła się powodzeniem'
                ];
        }
        else {
            $view = $this->renderView($this->getEditFormTemplate(), [
                'entity' => $entity,
                'form' => $form->createView()
                ]);

            $response = [
                "response" => false,
                "view"     => $view
                ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $entities = $this->getEntitiesByIds($arrayId);

        $em = $this->getDoctrine()->getManager();
        foreach ($entities as $entity) {
            $em->remove($entity);
        }

        try {
            $em->flush();

            $response = [
                "response" => true,
                "message"  => 'Usuwanie pozycji zakończyło się powodzeniem'
                ];
        } catch (\Exception $e) {
            $response = [
                "response" => false,
                "message"  => 'Usuwanie pozycji zakończyło się niepowodzeniem'
                ];
        }

        return new Response(json_encode($response));
    }

    private function setPagination($entities, $page = 1, $rowsOnPage = 10)
    {
        return $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);
    }
}