<?php

namespace My\AdminBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use My\AdminBundle\Form\ImportType;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

abstract class CRUDController extends Controller
{
    abstract protected function getListQB(array $params);

    abstract protected function getListTemplate();

    abstract protected function getEntityById($id);

    abstract protected function getEntitiesByIds(array $ids);

    abstract protected function getNewEntity($params);

    abstract protected function getForm($entity, $params);

    abstract protected function getNewFormTemplate();

    abstract protected function getEditFormTemplate();

    /**
     * @Route("/")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $params = $this->getListParameters($request->query);

        $entities = $this->getListQB($params);
        $pagination = $this->setPagination($entities, $params['page'], $params['rowsOnPage']);

        $list = $this->renderListView($pagination->getEntities(), $params['page'], $params['rowsOnPage']);

        $response = [
            "list"       => $list,
            "pagination" => $pagination->toArray(),
            "order"      => $params['order'],
            "response"   => true
        ];

        return new Response(json_encode($response));
    }

    protected function getListParameters(ParameterBag $query)
    {
        $params = [
            'rowsOnPage' => (int)$query->get('rowsOnPage', 10),
            'page'       => (int)$query->get('page', 1),
            'order'      => $query->get('order', 'a.name'),
            'sequence'   => $query->get('sequence', 'ASC'),
            'filter'     => $query->get('filter', null),
            'languageId' => (int)$query->get('languageId'),
            'groupId'    => (int)$query->get('groupId'),
            'sublistId'  => (int)$query->get('sublistId')
        ];

        $params = $this->paramsFilter($params);

        return $params;
    }

    protected function renderListView($entities, $page, $rowsOnPage)
    {
        return $this->renderView($this->getListTemplate(),
            compact('entities', 'page', 'rowsOnPage'));
    }

    /**
     * @Route("/new")
     * @Method("GET|POST")
     */
    public function newAction(Request $request)
    {
        $params = [
            'menuId'    => (int)$request->get('menuId'),
            'sublistId' => (int)$request->get('sublistId')
        ];

        $entity = $this->getNewEntity($params);
        $form = $this->getForm($entity, $params);

        if ($request->getMethod() == "POST" && $form->submit($request) && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($entity);

            $response = $this->get('my.flush.service')->tryFlush();
            $response['id'] = $entity->getId();
        } else {
            $response = [
                "response" => !($request->getMethod() == "POST") && !$form->isValid(),
                "view"     => $this->renderForm($entity, $form)
            ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/edit")
     * @Method("GET|POST")
     */
    public function editAction(Request $request, $id)
    {
        $params = [
            'menuId' => (int)$request->get('menuId')
        ];

        $entity = $this->getEntity($id);
        $form = $this->getForm($entity, $params);

        if ($request->getMethod() == "POST" && $form->submit($request) && $form->isValid()) {
            $response = $this->get('my.flush.service')->tryFlush();
            $response['id'] = $entity->getId();
        } else {
            $response = [
                "response" => !($request->getMethod() == "POST") && !$form->isValid(),
                "view"     => $this->renderForm($entity, $form)
            ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $entities = $this->getEntitiesByIds($arrayId);

        $em = $this->getDoctrine()->getManager();
        foreach ($entities as $entity) {
            $em->remove($entity);
        }

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/export")
     * @Method("POST")
     */
    public function exportAction(Request $request)
    {
        $arrayId = $request->get('arrayId');
        $entities = $this->getEntitiesByIds($arrayId);

        $serializer = $this->get('jms_serializer');
        $entitiesJson = $serializer->serialize($entities, 'json');

        $response = [
            "response" => true,
            "json"     => $entitiesJson
        ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/import")
     * @Method("GET|POST")
     */
    public function importAction(Request $request)
    {
        $params = [
            'menuId'    => (int)$request->get('menuId'),
            'sublistId' => (int)$request->get('sublistId')
        ];

        $form = $this->createForm(new ImportType());

        if ($request->getMethod() == "POST" && $form->submit($request) && $form->isValid()) {
            $file = $form->get('file')->getData();

            $serializer = $this->get('jms_serializer');
            $entitiesJson = $serializer->deserialize(file_get_contents($file), 'Doctrine\Common\Collections\ArrayCollection', 'json');

            if ($this->hasImportEntitiesMethod()) {
                $this->importEntities($entitiesJson, $params);
                $response = $this->get('my.flush.service')->tryFlush();
            } else {
                $response = [
                    "response" => true,
                    "message"  => 'Akcja niedostępna'
                ];
            }
        } else {
            $response = [
                "response" => !($request->getMethod() == "POST") && !$form->isValid(),
                "view"     => $this->renderView('MyAdminBundle:Admin:import.html.twig', [
                        'form'  => $form->createView(),
                        'route' => $request->get('_route')
                    ])
            ];
        }

        return new Response(json_encode($response));
    }

    private function hasImportEntitiesMethod()
    {
        return method_exists($this, 'importEntities');
    }

    private function setPagination(QueryBuilder $entitiesQb, $page = 1, $rowsOnPage = 10)
    {
        return $this->get('my.pagination.service')
            ->setPagination($entitiesQb, $page, $rowsOnPage);
    }

    protected function getEntity($id)
    {
        $entity = $this->getEntityById($id);
        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        return $entity;
    }

    protected function paramsFilter(array $params)
    {
        return $params;
    }

    private function renderForm($entity, $form)
    {
        return $this->renderView($this->getFormTemplate($entity), [
            'entity' => $entity,
            'form'   => $form->createView()
        ]);
    }

    private function getFormTemplate($entity)
    {
        if (null == $entity->getId()) {
            return $this->getNewFormTemplate();
        } else {
            return $this->getEditFormTemplate();
        }
    }
}