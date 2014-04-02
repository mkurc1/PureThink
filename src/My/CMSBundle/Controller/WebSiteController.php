<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\WebSite;
use My\CMSBundle\Form\WebSiteType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/website")
 */
class WebSiteController extends Controller
{
    /**
     * @Route("/edit/")
     * @Method("POST")
     */
    public function editAction(Request $request)
    {
        $languageId = (int)$request->get('languageId');

        if (null == $languageId) {
            $languageId = $this->getDefaultLanguageId();
        }

        $webSite = $this->getDoctrine()->getRepository('MyCMSBundle:WebSite')
            ->getWebSite($languageId);

        if (null == $webSite) {
            $webSite = $this->createWebSite($languageId);
        }

        $form = $this->createForm(new WebSiteType(), $webSite);

        $view = $this->renderView('MyCMSBundle:WebSite:_edit.html.twig',
            array('entity' => $webSite, 'form' => $form->createView()));

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
        $em = $this->getDoctrine()->getManager();

        $webSite = $em->getRepository('MyCMSBundle:WebSite')->find($id);

        if (!$webSite) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new WebSiteType(), $webSite);
        $form->bind($request);

        if ($form->isValid()) {
            $em->flush();

            $response = [
                "response" => true,
                "id"       => $webSite->getId(),
                "message"  => 'Edycja witryny zakończyła się powodzeniem'
                ];
        }
        else {
            $view = $this->renderView('MyCMSBundle:WebSite:_edit.html.twig',
                array('entity' => $webSite, 'form' => $form->createView()));

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
        $webSite->setLanguage($em->getRepository('MyCMSBundle:Language')->find($languageId));

        $em->persist($webSite);
        $em->flush();

        return $webSite;
    }

    private function getDefaultLanguageId() {
        $language = $this->getDoctrine()->getRepository('MyCMSBundle:Language')
            ->getFirstLanguage();

        return $language->getId();
    }
}
