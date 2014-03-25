<?php

namespace My\CMSBundle\Controller;

use My\CMSBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use My\CMSBundle\Entity\Article;
use My\CMSBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/cms/article")
 */
class ArticleController extends Controller
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

    protected function getNewEntity()
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

        $entity->setIsPublic(!$entity->getIsPublic());

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