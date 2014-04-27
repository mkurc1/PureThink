<?php

namespace My\CMSBundle\Controller;

use My\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Article;
use My\CMSBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/article")
 */
class ArticleController extends CRUDController
{
    protected function getListQB(array $params)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Article')
            ->getArticlesQB($params['order'], $params['sequence'], $params['filter'], $params['languageId'], $params['groupId']);
    }

    protected function getListTemplate()
    {
        return 'MyCMSBundle:Article:_list.html.twig';
    }

    protected function getEntityById($id)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Article')
            ->find($id);
    }

    protected function getEntitiesByIds(array $ids)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:Article')
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
        return 'MyCMSBundle:Article:_new.html.twig';
    }

    protected function getEditFormTemplate()
    {
        return 'MyCMSBundle:Article:_edit.html.twig';
    }

    public function importEntities($entitiesJson, $params)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($entitiesJson as $entityJson) {
            $entity = $this->getNewEntity($params);
            $entity->setName($entityJson['name']);
            $entity->setContent($entityJson['content']);
            $entity->setLanguage($em->getRepository('MyCMSBundle:Language')->find($entityJson['language']['id']));
            $entity->setSeries($em->getRepository('MyAdminBundle:Series')->find($entityJson['series']['id']));
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

        $response = $this->get('my.flush.service')->tryFlush();

        return new Response(json_encode($response));
    }
}