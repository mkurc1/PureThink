<?php

namespace My\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class LeftMenuController extends Controller
{
    /**
     * @Route("/left-menu", options={"expose"=true})
     * @Method("POST")
     */
    public function menuAction(Request $request)
    {
        $moduleId = (int)$request->get('moduleId');
        $menuId = (int)$request->get('menuId');
        $editMode = ($request->get('editMode') == 'true') ? true : false;

        $menu = '';
        $menus = [];

        switch ($moduleId) {
            case 1:
                $CMSLeftMenuController = $this->get('my.cms.leftMenu.service');
                $menus = $CMSLeftMenuController->menu($menuId);
                break;
        }

        foreach ($menus as $value) {
            $menu .= $value;
        }

        if (!$editMode) {
            $menu .= $this->getGroupsForMenu($menuId);
        }

        return new Response(json_encode(["menu" => $menu, "response" => true]));
    }

    private function getGroupsForMenu($menuId)
    {
        $entities = $this->getDoctrine()->getRepository('MyBackendBundle:Series')
            ->getGroupsByMenuId($menuId);

        return $this->renderView("MyBackendBundle:LeftMenu:_groups.html.twig",
            compact('entities'));
    }
}
