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

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:WebSite')->getWebSite($languageId);
        if (null == $entity) {
            $entity = $this->createWebSite($languageId);
        }

        $editForm = $this->createForm(new WebSiteType(), $entity);

        $view = $this->renderView('MyCMSBundle:WebSite:_edit.html.twig',
            array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view"     => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * @param integer $languageId
     * @return WebSite
     */
    private function createWebSite($languageId)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new WebSite();
        $entity->setLanguage($em->getRepository('MyCMSBundle:Language')->find($languageId));

        $em->persist($entity);
        $em->flush();

        return $entity;
    }

    private function getDefaultLanguageId() {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:Language')->getFirstLanguage();

        return $entity->getId();
    }

    /**
     * @Route("/{id}/update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:WebSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(new WebSiteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => 'Edycja witryny zakończyła się powodzeniem'
                );
        }
        else {
            $view = $this->renderView('MyCMSBundle:WebSite:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

            $response = array(
                "response" => false,
                "view" => $view
                );
        }

        return new Response(json_encode($response));
    }
}
