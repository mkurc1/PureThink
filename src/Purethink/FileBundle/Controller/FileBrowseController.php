<?php

namespace Purethink\FileBundle\Controller;

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
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page = (int)$request->get('page', 1);
        $order = $request->get('order', 'a.name');
        $sequence = $request->get('sequence', 'ASC');
        $filter = $request->get('filter');
        $groupId = (int)$request->get('groupId', 0);

        $entities = $this->getDoctrine()->getRepository('PurethinkFileBundle:File')
            ->getFilesQB($order, $sequence, $filter, $groupId);

        $pagination = $this->get('purethink.pagination.service')
            ->setPagination($entities, $page, $rowsOnPage);

        $list = $this->renderView('PurethinkFileBundle:FileBrowse:_list.html.twig',
            ['entities' => $pagination->getEntities(), 'page' => $page, 'rowsOnPage' => $rowsOnPage]);

        $response = [
            "list"       => $list,
            "pagination" => $pagination->toArray(),
            "response"   => true
            ];

        return new Response(json_encode($response));
    }
}