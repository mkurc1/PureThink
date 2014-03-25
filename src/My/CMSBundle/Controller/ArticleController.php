<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\Article;
use My\CMSBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/")
     * @Method("POST")
     */
    public function listAction(Request $request)
    {
        $rowsOnPage = (int)$request->get('rowsOnPage', 10);
        $page       = (int)$request->get('page', 1);
        $order      = $request->get('order', 'a.name');
        $sequence   = $request->get('sequence', 'ASC');
        $filter     = $request->get('filtr', null);
        $languageId = (int)$request->get('languageId');
        $groupId    = (int)$request->get('groupId');

        $articlesQB = $this->getDoctrine()->getRepository('MyCMSBundle:Article')
            ->getArticlesQB($order, $sequence, $filter, $languageId, $groupId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($articlesQB, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:Article:_list.html.twig',
            ['entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage]);

        $response = [
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true
            ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new Article();
        $entity->setUser($this->getUser());

        $form = $this->createForm(new ArticleType(), $entity, compact('menuId'));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $response = [
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Dodawanie artykułu zakończyło się powodzeniem'
                ];
        }
        else {
            $view = $this->renderView('MyCMSBundle:Article:_new.html.twig',
                ['entity' => $entity, 'form' => $form->createView()]);

            $response = [
                "response" => false,
                "view"     => $view
                ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new Article();
        $form = $this->createForm(new ArticleType(), $entity, compact('menuId'));

        $view = $this->renderView('MyCMSBundle:Article:_new.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
            ];

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{id}/edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:Article')->find($id);

        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ArticleType(), $entity, compact('menuId'));

        $view = $this->renderView('MyCMSBundle:Article:_edit.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

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
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:Article')->find($id);

        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ArticleType(), $entity, compact('menuId'));
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $response = [
                "response" => true,
                "id"       => $entity->getId(),
                "message"  => 'Edycja artykułu zakończyła się powodzeniem'
                ];
        }
        else {
            $view = $this->renderView('MyCMSBundle:Article:_edit.html.twig',
                ['entity' => $entity, 'form' => $form->createView()]);

            $response = [
                "response" => false,
                "view"     => $view
                ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $articles = $this->getDoctrine()->getRepository('MyCMSBundle:Article')
            ->getArticlesByIds($arrayId);

        $response = $this->get('my.manageList.service')
            ->deleteEntities($articles);

        return new Response(json_encode($response));
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:Article')->find($id);

        if (null == $entity) {
            throw $this->createNotFoundException();
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

            $response = [
                "response" => true,
                "message"  => 'Zmiana stanu artykułu zakończyła się powodzeniem'
                ];
        } catch (\Exception $e) {
            $response = [
                "response" => false,
                "message"  => 'Zmiana stanu artykułu zakończyła się niepowodzeniem'
                ];
        }

        return new Response(json_encode($response));
    }
}