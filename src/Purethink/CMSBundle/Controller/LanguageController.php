<?php

namespace Purethink\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Purethink\CMSBundle\Entity\Language;

/**
 * @Route("/admin/cms")
 */
class LanguageController extends Controller
{
    /**
     * @Route("/language/add")
     * @Method("POST")
     */
    public function addLanguageAction(Request $request)
    {
        $name = $request->get('name');
        $alias = $request->get('alias');

        $entity = new Language($name, $alias);

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);

        $response = $this->get('purethink.flush.service')->tryFlush();
        $response['id'] = $entity->getId();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/language/edit")
     * @Method("POST")
     */
    public function editLanguageAction(Request $request)
    {
        $id = (int)$request->get('id');
        $name = $request->get('name');
        $alias = $request->get('alias');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PurethinkCMSBundle:Language')->find($id);
        $entity->setName($name);
        $entity->setAlias($alias);

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/language/remove")
     * @Method("POST")
     */
    public function removeLanguageAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PurethinkCMSBundle:Language')->find($id);
        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        $em->remove($entity);

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }

    /**
     * @Route("/language/state")
     * @Method("POST")
     */
    public function changeStateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PurethinkCMSBundle:Language')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $entity->setIsPublic(!$entity->getIsPublic());

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}
