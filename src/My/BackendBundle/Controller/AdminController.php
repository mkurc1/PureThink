<?php

namespace My\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/", name="backend")
     * @Template()
     */
    public function indexAction()
    {
        $modules = $this->getModules();

        return compact('modules');
    }

    /**
     * @Route("/menu", options={"expose"=true})
     * @Method("POST")
     */
    public function menuAction(Request $request)
    {
        $moduleId = (int)$request->get('moduleId');

        $entities = $this->getMenuForModule($moduleId);

        $menu = $this->renderView('MyBackendBundle:Admin:_menu.html.twig', compact('entities'));

        $response = ["menu" => $menu, "response" => true];

        return new Response(json_encode($response));
    }

    private function getModules()
    {
        return $this->getDoctrine()->getRepository('MyBackendBundle:Module')->findAll();
    }

    private function getMenuForModule($moduleId)
    {
        return $this->getDoctrine()->getRepository('MyBackendBundle:Menu')
            ->getMenuForModule($moduleId);
    }
}
