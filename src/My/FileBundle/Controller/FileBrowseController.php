<?php

namespace My\FileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * File controller.
 *
 * @Route("/file/browse")
 */
class FileBrowseController extends Controller
{
    /**
     * Lists all File entities.
     *
     * @Route("/list", name="file_browse")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyFileBundle:File')->findAll();

        return array('entities' => $entities, 'page' => 1);
    }
}