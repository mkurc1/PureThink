<?php

namespace My\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    /**
     * @Route("/menu")
     */
    public function menuAction(Request $request)
    {
		$moduleId = (int)$request->get('moduleId');

		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('MyBackendBundle:Menu')->getMenus($moduleId);

		$menu = $this->renderView('MyBackendBundle:Menu:_menu.html.twig', array('entities' => $entities));

		$response = array("menu" => $menu, "response" => true);

		return new Response(json_encode($response));
    }
}
