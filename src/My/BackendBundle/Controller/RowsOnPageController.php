<?php

namespace My\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class RowsOnPageController extends Controller
{
    /**
     * @Route("/rows_on_page")
     */
    public function menuAction()
    {
        $request = $this->container->get('request');
        $rowsOnPageId = (int)$request->get('rowsOnPageId');

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MyBackendBundle:RowsOnPage')->findAll();

        $rows = $this->renderView('MyBackendBundle:RowsOnPage:_rows_on_page.html.twig', array('entities' => $entities, 'rowsOnPageId' => $rowsOnPageId));

        $response = array("rows" => $rows, "response" => true);

        return new Response(json_encode($response));
    }
}
