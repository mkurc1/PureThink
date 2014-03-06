<?php

namespace My\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class RowsOnPageController extends Controller
{
    /**
     * @Route("/rows_on_page")
     * @Method("POST")
     */
    public function getRowsOnPageAction(Request $request)
    {
        $rowsOnPageId = (int)$request->get('rowsOnPageId');

        $entities = $this->getDoctrine()->getRepository('MyBackendBundle:RowsOnPage')->findAll();

        $rows = $this->renderView('MyBackendBundle:RowsOnPage:_rows_on_page.html.twig',
            array('entities' => $entities, 'rowsOnPageId' => $rowsOnPageId));

        $response = array("rows" => $rows, "response" => true);

        return new Response(json_encode($response));
    }
}
