<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSWebSite;
use My\CMSBundle\Form\CMSWebSiteType;
use Symfony\Component\HttpFoundation\Response;

/**
 * CMSWebSite controller.
 *
 * @Route("/website")
 */
class CMSWebSiteController extends Controller
{
    /**
     * Displays a form to edit an existing CMSWebSite entity.
     *
     * @Route("/edit/", name="cmswebsite_edit")
     * @Method("POST")
     */
    public function editAction(Request $request)
    {
        $languageId = (int)$request->get('languageId');

        if ($languageId == 0) {
            $languageId = $this->getDefaultLanguageId();
        }

        $em = $this->getDoctrine()->getManager();

        try {
            $entity = $em->getRepository('MyCMSBundle:CMSWebSite')->getWebSite($languageId);
        } catch (\Exception $e) {
            $entity = $this->createWebSite($languageId);
        }

        $editForm = $this->createForm(new CMSWebSiteType(), $entity);

        $view = $this->renderView('MyCMSBundle:CMSWebSite:_edit.html.twig', array('entity' => $entity, 'form' => $editForm->createView()));

        $response = array(
            "response" => true,
            "view" => $view
            );

        return new Response(json_encode($response));
    }

    /**
     * Create web site
     *
     * @param integer $languageId
     * @return CMSWebSite
     */
    private function createWebSite($languageId) {
        $em = $this->getDoctrine()->getManager();

        $entity = new CMSWebSite();
        $entity->setLanguage($em->getRepository('MyCMSBundle:CMSLanguage')->find($languageId));

        $em->persist($entity);
        $em->flush();

        return $entity;
    }

    /**
     * Get default language ID
     *
     * @return integer
     */
    private function getDefaultLanguageId() {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSLanguage')->getFirstLanguage();

        return $entity->getId();
    }

    /**
     * Edits an existing CMSWebSite entity.
     *
     * @Route("/{id}/update", name="cmswebsite_update")
     * @Method("PUT")
     * @Template("MyCMSBundle:CMSWebSite:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSWebSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSWebSite entity.');
        }

        $editForm = $this->createForm(new CMSWebSiteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cmswebsite_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }
}
