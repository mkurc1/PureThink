<?php

namespace Purethink\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\WebSite;
use Purethink\CMSBundle\Form\WebSiteType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/website")
 */
class WebSiteController extends Controller
{
    /**
     * @Route("/edit/")
     * @Method("GET")
     */
    public function editAction(Request $request)
    {
        $languageId = (int)$request->get('languageId');

        if (null == $languageId) {
            $languageId = $this->getDefaultLanguageId();
        }

        $webSite = $this->getDoctrine()->getRepository('PurethinkCMSBundle:WebSite')
            ->getWebSite($languageId);

        if (null == $webSite) {
            $webSite = $this->createWebSite($languageId);
        }

        $form = $this->createForm(new WebSiteType(), $webSite);

        $view = $this->renderView('PurethinkCMSBundle:WebSite:_edit.html.twig',
            ['entity' => $webSite, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
        ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $webSite = $this->getDoctrine()->getRepository('PurethinkCMSBundle:WebSite')->find($id);
        if (null == $webSite) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new WebSiteType(), $webSite);

        if ($form->submit($request) && $form->isValid()) {
            $response = $this->get('purethink.flush.service')->tryFlush();
            $response['id'] = $webSite->getId();
        } else {
            $view = $this->renderView('PurethinkCMSBundle:WebSite:_edit.html.twig',
                ['entity' => $webSite, 'form' => $form->createView()]);

            $response = [
                "response" => false,
                "view"     => $view
            ];
        }

        return new Response(json_encode($response));
    }

    private function createWebSite($languageId)
    {
        $em = $this->getDoctrine()->getManager();

        $webSite = new WebSite();
        $webSite->setLanguage($em->getRepository('PurethinkCMSBundle:Language')->find($languageId));

        $em->persist($webSite);
        $em->flush();

        return $webSite;
    }

    private function getDefaultLanguageId()
    {
        $language = $this->getDoctrine()->getRepository('PurethinkCMSBundle:Language')
            ->getFirstLanguage();

        return $language->getId();
    }
}
