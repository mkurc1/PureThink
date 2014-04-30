<?php

namespace Purethink\AdminBundle\Controller;

use Purethink\AdminBundle\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Route("{module}/menu", options={"expose"=true})
     * @Method("GET")
     */
    public function menuAction(Module $module)
    {
        $entities = $this->getMenuForModule($module);

        $menu = $this->renderView('PurethinkAdminBundle:Admin:_menu.html.twig', compact('entities'));

        return new Response($menu);
    }

    private function getModules()
    {
        return $this->getDoctrine()->getRepository('PurethinkAdminBundle:Module')->findAll();
    }

    private function getMenuForModule($module)
    {
        return $this->getDoctrine()->getRepository('PurethinkAdminBundle:Menu')
            ->getMenuForModule($module);
    }
}
