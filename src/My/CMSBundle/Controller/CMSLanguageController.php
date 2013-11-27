<?php

namespace My\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use My\CMSBundle\Entity\CMSLanguage;

class CMSLanguageController extends Controller
{
    /**
     * @Route("/language/add", name="cms_language_new")
     */
    public function addLanguageAction()
    {
        $request = $this->container->get('request');

        $name = $request->get('name');

        $em = $this->getDoctrine()->getManager();

        $entity = new CMSLanguage();
        $entity->setName($name);
        $entity->setIsPublic(false);

        $em->persist($entity);

        try {
            $em->flush();

            $response = array(
                "response" => true,
                "id" => $entity->getId(),
                "message" => "Dodanie języka zakończyło się powodzeniem"
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message" => "Dodanie języka zakończyło się niepowodzeniem"
                );
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/language/edit", name="cms_language_edit")
     */
    public function editLanguageAction()
    {
        $request = $this->container->get('request');

        $id = (int)$request->get('id');
        $name = $request->get('name');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSLanguage')->find($id);
        $entity->setName($name);

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
     */
    public function removeGroupAction()
    {
        $request = $this->container->get('request');

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
}
