<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use My\CMSBundle\Entity\CMSArticle;
use My\CMSBundle\Form\CMSArticleType;
use Symfony\Component\HttpFoundation\Response;

/**
 * CMSArticle controller.
 *
 * @Route("/admin/cms/article")
 */
class CMSArticleController extends Controller
{
    /**
     * Lists all CMSArticle entities.
     *
     * @Route("/", name="cmsarticle")
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

        $articlesQB = $this->getDoctrine()->getRepository('MyCMSBundle:CMSArticle')
            ->getArticlesQB($order, $sequence, $filter, $languageId, $groupId);

        $pagination = $this->get('my.pagination.service')
            ->setPagination($articlesQB, $page, $rowsOnPage);

        $list = $this->renderView('MyCMSBundle:CMSArticle:_list.html.twig',
            ['entities' => $pagination['entities'], 'page' => $page, 'rowsOnPage' => $rowsOnPage]);

        $response = [
            "list"       => $list,
            "pagination" => $pagination,
            "response"   => true
            ];

        return new Response(json_encode($response));
    }

    /**
     * Creates a new CMSArticle entity.
     *
     * @Route("/create", name="cmsarticle_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new CMSArticle();
        $entity->setUser($this->getUser());

        $form = $this->createForm(new CMSArticleType(), $entity, compact('menuId'));
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
            $view = $this->renderView('MyCMSBundle:CMSArticle:_new.html.twig',
                ['entity' => $entity, 'form' => $form->createView()]);

            $response = [
                "response" => false,
                "view"     => $view
                ];
        }

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to create a new CMSArticle entity.
     *
     * @Route("/new", name="cmsarticle_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $menuId = (int)$request->get('menuId');

        $entity = new CMSArticle();
        $form = $this->createForm(new CMSArticleType(), $entity, compact('menuId'));

        $view = $this->renderView('MyCMSBundle:CMSArticle:_new.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
            ];

        return new Response(json_encode($response));
    }

    /**
     * Displays a form to edit an existing CMSArticle entity.
     *
     * @Route("/{id}/edit", name="cmsarticle_edit")
     * @Method("POST")
     */
    public function editAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new CMSArticleType(), $entity, compact('menuId'));

        $view = $this->renderView('MyCMSBundle:CMSArticle:_edit.html.twig',
            ['entity' => $entity, 'form' => $form->createView()]);

        $response = [
            "response" => true,
            "view"     => $view
            ];

        return new Response(json_encode($response));
    }

    /**
     * Edits an existing CMSArticle entity.
     *
     * @Route("/{id}/update", name="cmsarticle_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $menuId = (int)$request->get('menuId');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

        if (null == $entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new CMSArticleType(), $entity, compact('menuId'));
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
            $view = $this->renderView('MyCMSBundle:CMSArticle:_edit.html.twig',
                ['entity' => $entity, 'form' => $form->createView()]);

            $response = [
                "response" => false,
                "view"     => $view
                ];
        }

        return new Response(json_encode($response));
    }

    /**
     * Deletes a CMSArticle entity.
     *
     * @Route("/delete", name="cmsarticle_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $arrayId = $request->get('arrayId');

        $articles = $this->getDoctrine()->getRepository('MyCMSBundle:CMSArticle')
            ->getArticlesByIds($arrayId);

        $response = $this->get('my.manageList.service')
            ->deleteEntities($articles);

        return new Response(json_encode($response));
    }

    /**
     * Change state a CMSArticle entity.
     *
     * @Route("/state", name="cmsarticle_state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyCMSBundle:CMSArticle')->find($id);

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