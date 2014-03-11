<?php

namespace My\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class RowsOnPageController extends Controller
{
    /**
     * @Route("/rows", options={"expose"=true})
     * @Method("POST")
     */
    public function getRowsOnPageAction(Request $request)
    {
        $rowsOnPageId = (int)$request->get('rowsOnPageId');

        $entities = $this->getDoctrine()->getRepository('MyBackendBundle:RowsOnPage')->findAll();

        $rows = $this->renderView('MyBackendBundle:RowsOnPage:_rows_on_page.html.twig',
            compact('entities', 'rowsOnPageId'));

        $response = ["rows" => $rows, "response" => true];

        return new Response(json_encode($response));
    }
}
