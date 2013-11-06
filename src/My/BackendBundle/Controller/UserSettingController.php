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
    public function getUserSettingAction()
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
                'moduleId' => $entity->getModule()->getId()
                ),
            "response" => true
            );

        return new Response(json_encode($response));
    }

    /**
     * @Route("/user/setting/set_rows_on_page")
     */
    public function setRowsOnPage()
    {
        $request = $this->container->get('request');
        $rowsOnPage = (int)$request->get('rowsOnPage');

        $em = $this->getDoctrine()->getManager();

        $RowsOnPage = $em->getRepository('MyBackendBundle:RowsOnPage')
            ->findOneByAmount($rowsOnPage);

        $UserSetting = $em->getRepository('MyBackendBundle:UserSetting')
            ->findOneByUser($this->getUser());

        $UserSetting->setRowsOnPage($RowsOnPage);

        $em->persist($UserSetting);
        $em->flush();

        $response = array(
            "row_id" => $RowsOnPage->getId(),
            "response" => true
            );

        return new Response(json_encode($response));
    }
}
