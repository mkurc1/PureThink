<?php

namespace My\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use My\UserBundle\Entity\UserSetting;

class UserSettingController extends Controller
{
    /**
     * @Route("/user/setting", options={"expose"=true})
     * @Method("POST")
     */
    public function getUserSettingAction(Request $request)
    {
        $user = $this->getUser();
        $setting = $user->getUserSetting();

        $this->checkCorrectSetting($setting);

        $response = [
            "setting" => [
                'userId'       => $user->getId(),
                'rowsOnPageId' => $setting->getRowsOnPage()->getId(),
                'languageId'   => $setting->getLanguage()->getId(),
                'moduleId'     => $setting->getModule()->getId()
                ],
            "response" => true
            ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/user/setting/set-rows", options={"expose"=true})
     * @Method("POST")
     */
    public function setRowsOnPageAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage');

        $em = $this->getDoctrine()->getManager();

        $rowsOnPage = $em->getRepository('MyBackendBundle:RowsOnPage')
            ->findOneByAmount($rowsOnPage);

        $userSetting = $this->getUser()->getUserSetting();
        $userSetting->setRowsOnPage($rowsOnPage);

        $em->flush();

        $response = [
            "row_id" => $rowsOnPage->getId(),
            "response" => true
            ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/user/setting/set", options={"expose"=true})
     * @Method("POST")
     */
    public function setUserSettingAction(Request $request)
    {
        $rowsOnPageId = (int)$request->get('rowsOnPageId');
        $moduleId     = (int)$request->get('moduleId');
        $languageId   = (int)$request->get('languageId');

        $em = $this->getDoctrine()->getManager();

        $userSetting = $this->getUser()->getUserSetting();
        $userSetting->setRowsOnPage($em->getRepository('MyBackendBundle:RowsOnPage')->find($rowsOnPageId));
        $userSetting->setModule($em->getRepository('MyBackendBundle:Module')->find($moduleId));
        $userSetting->setLanguage($em->getRepository('MyBackendBundle:Language')->find($languageId));

        $em->flush();

        $response = [
            "response" => true
            ];

        return new Response(json_encode($response));
    }

    private function checkCorrectSetting(UserSetting $setting)
    {
        $em = $this->getDoctrine()->getManager();

        if (null == $setting->getRowsOnPage()) {
            $defaultCoutRows = $em->getRepository('MyBackendBundle:RowsOnPage')
                ->findOneByIsDefault(true);
            $setting->setRowsOnPage($defaultCoutRows);
        }

        if (null == $setting->getLanguage()) {
            $defaultModule = $em->getRepository('MyBackendBundle:Module')
                ->findOneByIsDefault(true);
            $setting->setModule($defaultModule);
        }

        if (null == $setting->getLanguage()) {
            $defaultLanguage = $em->getRepository('MyBackendBundle:Language')
                ->findOneByIsDefault(true);
            $setting->setLanguage($defaultLanguage);
        }

        $em->flush();
    }
}
