<?php

namespace My\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class LeftMenuController extends Controller
{
    /**
     * @Route("/left_menu")
     */
    public function menuAction(Request $request)
    {
        $moduleId = (int)$request->get('moduleId');
        $menuId = (int)$request->get('menuId');

        $menu = '';
        $menus = array();

        switch ($moduleId) {
            case 1:
                $CMSLeftMenuController = $this->get('my_cms_left_menu');
                $menus = $CMSLeftMenuController->menu($menuId);
                break;
        }

        foreach ($menus as $value) {
            $menu .= $value;
        }

        $menu .= $this->getGroups($menuId);

        $response = array("menu" => $menu, "response" => true);

        return new Response(json_encode($response));
    }

    /**
     * Get groups
     *
     * @param integer $menuId
     * @return array
     */
    Private function getGroups($menuId)
    {
        $entities = $this->getDoctrine()->getRepository('MyBackendBundle:Series')->getGroupsByMenuId($menuId);

        return $this->renderView("MyBackendBundle:LeftMenu:_groups.html.twig", array('entities' => $entities));
    }
}
