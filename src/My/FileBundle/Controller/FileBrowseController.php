<?php

namespace My\FileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * File controller.
 *
 * @Route("/browse")
 */
class FileBrowseController extends Controller
{
    /**
     * Lists all File entities.
     *
     * @Route("/", name="file_browse")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * Lists all File entities.
     *
     * @Route("/list", options={"expose"=true})
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page = (int)$request->get('page', 1);
        $order = $request->get('order', 'a.name');
        $sequence = $request->get('sequence', 'ASC');
        $filtr = $request->get('filtr');
        $groupId = (int)$request->get('groupId', 0);

        $entities = $this->getDoctrine()->getRepository('MyFileBundle:File')
            ->getFilesQB($order, $sequence, $filtr, $groupId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('MyFileBundle:FileBrowse:_list.html.twig',
            ['entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage]);

        $response = [
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true
            ];

        return new Response(json_encode($response));
    }
}