<?php

namespace Purethink\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Purethink\UserBundle\Entity\UserSetting;

class UserSettingController extends Controller
{
    /**
     * @Route("/user/rows", options={"expose"=true})
     * @Method("GET")
     */
    public function getUserRowsOnPageAction(Request $request)
    {
        $rowsOnPageId = (int)$request->get('rowsOnPageId');

        $entities = UserSetting::getAvilableCountRowsOnPage();

        $rows = $this->renderView('PurethinkUserBundle:UserSetting:_rowsOnPage.html.twig',
            compact('entities', 'rowsOnPageId'));

        return new Response($rows);
    }

    /**
     * @Route("/user/setting", options={"expose"=true})
     * @Method("GET")
     */
    public function getUserSettingAction()
    {
        $user = $this->getUser();
        $setting = $user->getUserSetting();

        $this->checkCorrectSetting($setting);

        $settings = [
            'userId'       => $user->getId(),
            'rowsOnPageId' => $setting->getRowsOnPage(),
            'languageId'   => $setting->getLanguage()->getId(),
            'moduleId'     => $setting->getModule()->getId()
        ];

        return new Response(json_encode($settings));
    }

    /**
     * @Route("/user/setting/set-rows", options={"expose"=true})
     * @Method("POST")
     */
    public function setRowsOnPageAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage');

        $userSetting = $this->getUser()->getUserSetting();
        $userSetting->setRowsOnPageByValue($rowsOnPage);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response($userSetting->getRowsOnPage());
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
        $userSetting->setRowsOnPage($rowsOnPageId);
        $userSetting->setModule($em->getRepository('PurethinkAdminBundle:Module')->find($moduleId));
        $userSetting->setLanguage($em->getRepository('PurethinkAdminBundle:Language')->find($languageId));

        $em->flush();

        return new Response('OK');
    }

    private function checkCorrectSetting(UserSetting $setting)
    {
        $em = $this->getDoctrine()->getManager();

        if (null == $setting->getRowsOnPage()) {
            $setting->setRowsOnPage(1);
        }

        if (null == $setting->getLanguage()) {
            $defaultModule = $em->getRepository('PurethinkAdminBundle:Module')
                ->findOneByIsDefault(true);
            $setting->setModule($defaultModule);
        }

        if (null == $setting->getLanguage()) {
            $defaultLanguage = $em->getRepository('PurethinkAdminBundle:Language')
                ->findOneByIsDefault(true);
            $setting->setLanguage($defaultLanguage);
        }

        $em->flush();
    }
}
