<?php

namespace My\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    /**
     * @Route("/menu")
     */
    public function menuAction()
    {
		$request = $this->container->get('request');        
		$moduleId = (int)$request->get('moduleId');

		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('MyBackendBundle:Menu')->getMenu($moduleId);

		$menu = $this->renderView('MyBackendBundle:Menu:_menu.html.twig', array('entities' => $entities));

		$response = array("menu" => $menu, "response" => true);

		return new Response(json_encode($response)); 
    }
}
