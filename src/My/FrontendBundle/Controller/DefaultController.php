<?php

namespace My\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="frontend")
     */
    public function mainAction(Request $request)
    {
        $locale = $request->getLocale();

        return $this->redirect($this->generateUrl('localized_frontend', array('locale' => $locale)));
    }

    /**
     * @Route("/{locale}", name="localized_frontend")
     * @Template()
     */
    public function indexAction(Request $request, $locale)
    {
        $request->setLocale($locale);

        $meta = $this->getMeta($locale);
        $languages = $this->getLanguages();
        $menus = $this->getMenus($locale);
        $components = $this->getComponents($locale);

        return array(
            'locale' => $locale,
            'meta' => $meta,
            'languages' => $languages,
            'menus' => $menus,
            'components' => $components
            );
    }

    /**
     * @Route("/{locale}/{slug}", name="article")
     * @Template()
     */
    public function articleAction(Request $request, $locale, $slug)
    {
        $request->setLocale($locale);

        $languages = $this->getLanguages();
        $menus = $this->getMenus($locale);

        $article = $this->getArticle($slug);

        return array(
            'locale' => $locale,
            'languages' => $languages,
            'menus' => $menus,
            'article' => $article
            );
    }

    /**
     * Get article
     *
     * @param string $slug
     * @return object
     */
    public function getArticle($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('MyCMSBundle:CMSMenu')->findOneBySlug($slug);

        return $menu->getArticle();
    }

    /**
     * Get menus
     *
     * @param string $locale
     * @return object
     */
    private function getMenus($locale)
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('MyCMSBundle:CMSMenu')->getPublicMenus($locale);
    }

    /**
     * Get components
     *
     * @param string $locale
     * @return array
     */
    private function getComponents($locale)
    {
        $components = array();

        $em = $this->getDoctrine()->getManager();

        $enties = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->getComponents($locale);
        foreach ($enties as $key => $entity) {
            $content = $entity['content'];

            switch ($entity['type']) {
                case 'Article':
                    $content = $em->getRepository('MyCMSBundle:CMSArticle')
                        ->find((int)$content)->getSlug();
                    break;
                case 'File':
                    $content = $em->getRepository('MyFileBundle:File')
                        ->find((int)$content)->getPath();
                    break;
            }

            $components[$entity['slug']][$entity['elementId']][$entity['subname']] = $content;
        }

        return $components;
    }

    /**
     * Get meta
     *
     * @param string $locale
     * @return object
     */
    private function getMeta($locale)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            return $em->getRepository('MyCMSBundle:CMSWebsite')->getMeta($locale);
        }
        catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get public languages
     *
     * @return array
     */
    private function getLanguages()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('MyCMSBundle:CMSLanguage')->getPublicLanguages();
    }
}
