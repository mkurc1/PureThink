<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\Article;
use Purethink\CMSBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/article")
 */
class ArticleController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Article')
            ->getArticlesQB($params['order'], $params['sequence'], $params['filter'], $params['languageId'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'PurethinkCMSBundle:Article:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Article')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Article')
            ->getArticlesByIds($ids);
    }

    protected function getNewEntity($params)
    {
        return new Article($this->getUser());
    }

    protected function getForm($entity, $params)
    {
        return $this->createForm(new ArticleType(), $entity, ['menuId' => $params['menuId']]);
    }

    protected function getNewFormTemplate()
    {
        return 'PurethinkCMSBundle:Article:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'PurethinkCMSBundle:Article:_edit.html.twig';
    }

    public function importEntities($entitiesJson, $params)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($entitiesJson as $entityJson) {
            $entity = $this->getNewEntity($params);
            $entity->setName($entityJson['name']);
            $entity->setContent($entityJson['content']);
            $entity->setLanguage($em->getRepository('PurethinkCMSBundle:Language')->find($entityJson['language']['id']));
            $entity->setSeries($em->getRepository('PurethinkAdminBundle:Series')->find($entityJson['series']['id']));
            $em->persist($entity);
        }
    }

    /**
     * @Route("/state")
     * @Method("POST")
     */
    public function stateAction(Request $request)
    {
        $id = (int)$request->get('id');

        $entity = $this->getEntity($id);
        $entity->setIsPublic(!$entity->getIsPublic());

        $response = $this->get('purethink.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}