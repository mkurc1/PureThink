<?php

namespace My\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
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

        $menu = $this->renderView('MyAdminBundle:Admin:_menu.html.twig', compact('entities'));

        $response = ["menu" => $menu, "response" => true];

        return new Response(json_encode($response));
    }

    private function getModules()
    {
        return $this->getDoctrine()->getRepository('MyAdminBundle:Module')->findAll();
    }

    private function getMenuForModule($moduleId)
    {
        return $this->getDoctrine()->getRepository('MyAdminBundle:Menu')
            ->getMenuForModule($moduleId);
    }
}
