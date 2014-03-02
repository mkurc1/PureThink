<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use My\CMSBundle\Entity\CMSLanguage;

/**
 * @Route("/admin/cms")
 */
class CMSLanguageController extends Controller
{
    /**
     * @Route("/language/add", name="cms_language_new")
     * @Method("POST")
     */
    public function addLanguageAction(Request $request)
    {
        $name = $request->get('name');
        $alias = $request->get('alias');

        $em = $this->getDoctrine()->getManager();

        $entity = new CMSLanguage();
        $entity->setName($name);
        $entity->setAlias($alias);
        $entity->setIsPublic(false);

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => "Dodanie języka zakończyło się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message"  => "Dodanie języka zakończyło się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/language/edit", name="cms_language_edit")
     * @Method("POST")
     */
    public function editLanguageAction(Request $request)
    {
        $id = (int)$request->get('id');
        $name = $request->get('name');
        $alias = $request->get('alias');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSLanguage')->find($id);
        $entity->setName($name);
        $entity->setAlias($alias);

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => "Edycja języka zakończyła się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => "Edycja języka zakończyła się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/language/remove", name="cms_language_remove")
     * @Method("POST")
     */
    public function removeGroupAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyCMSBundle:CMSLanguage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSLanguage entity.');
        }

        $em->remove($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => "Usuwanie języka zakończyło się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => "Usuwanie języka zakończyło się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/language/state", name="cms_language_state")
     * @Method("POST")
     */
    public function changeStateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyCMSBundle:CMSLanguage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CMSLanguage entity.');
        }

        if ($entity->getIsPublic()) {
            $entity->setIsPublic(false);
        }
        else {
            $entity->setIsPublic(true);
        }

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "message" => "Zmiana stanu języka zakończyła się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => "Zmiana stanu języka zakończyła się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }
}
