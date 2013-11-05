<?php

namespace My\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class UserSettingController extends Controller
{
    /**
     * @Route("/user/setting")
     */
    public function menuAction()
    {
        $request = $this->container->get('request');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyBackendBundle:UserSetting')
            ->findOneBy(array('user' => $this->getUser()));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserSetting entity.');
        }

        $response = array(
            "setting" => array(
                'userId' => $entity->getUser()->getId(),
                'rowsOnPageId' => $entity->getRowsOnPage()->getId(),
                'languageId' => $entity->getLanguage()->getId(),
                'moduleId' => $entity->getModule()->getId(),
                'menuId' => $entity->getMenu()->getId()
                ),
            "response" => true
            );

        return new Response(json_encode($response));
    }
}
