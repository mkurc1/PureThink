<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Response;
use My\CMSBundle\Entity\CMSArticle;

class CMSFrontendController extends Controller
{
    /**
     * @Route("/", name="frontend")
     * @Method("GET")
     */
    public function mainAction(Request $request)
    {
        $languages = $this->getLanguages();
        $avilableLocales = $this->getAvilableLocales($languages);

        $locale = $request->getPreferredLanguage($avilableLocales);

        return $this->forward('MyCMSBundle:CMSFrontend:index', compact('locale'));
    }

    /**
     * Component Action
     *
     * @param  Request $request
     * @param  stirng  $slug
     * @param  string  $template
     * @return array
     */
    public function componentAction(Request $request, $slug, $template)
    {
        $locale = $request->getLocale();

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')
            ->getActiveComponentBySlugAndLocale($slug, $locale);

        if (count($entities) == 0) {
            return new Response();
        }

        return $this->render($template, compact('entities', 'locale'));
    }

    /**
     * @Route("/{locale}", name="localized_frontend")
     * @Method("GET")
     * @Template()
     * @Cache(maxage="3600")
     */
    public function indexAction(Request $request, $locale)
    {
        $languages = $this->getLanguages();
        if ($this->checkAvilableLocales($languages, $locale)) {
            $request->setLocale($locale);
        }
        else {
            return $this->redirect($this->generateUrl('frontend'));
        }

        $meta = $this->getMetadataByLocale($locale);
        $menus = $this->getMenus($locale);

        return compact('locale', 'meta', 'languages', 'menus');
    }

    /**
     * @Route("/{locale}/search", name="search")
     * @Method("GET")
     * @Template()
     */
    public function searchAction(Request $request, $locale)
    {
        $languages = $this->getLanguages();
        if ($this->checkAvilableLocales($languages, $locale)) {
            $request->setLocale($locale);
        }
        else {
            return $this->redirect($this->generateUrl('frontend'));
        }

        $meta = $this->getMetadataByLocale($locale);
        $menus = $this->getMenus($locale);

        $search = $request->get('article');

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('MyCMSBundle:CMSArticle')->search($locale, $search);

        return compact('locale', 'meta', 'languages', 'menus', 'articles');
    }

    /**
     * @Route("/{locale}/{slug}/{slug2}", name="article")
     * @Method("GET")
     * @Template()
     */
    public function articleAction(Request $request, $locale, $slug, $slug2 = null)
    {
        $languages = $this->getLanguages();
        if ($this->checkAvilableLocales($languages, $locale)) {
            $request->setLocale($locale);
        }
        else {
            return $this->redirect($this->generateUrl('frontend'));
        }

        $menus = $this->getMenus($locale);

        if (null == $slug2) {
            $article = $this->getArticle($slug);
        }
        else {
            $article = $this->getArticle($slug2);
        }

        if (null == $article) {
            throw $this->createNotFoundException();
        }

        $this->incremetArticleViews($article);

        $url = [
            'slug'  => $slug,
            'slug2' => $slug2
            ];

        return compact('locale', 'languages', 'menus', 'article', 'url');
    }

    /**
     * Incremet article views
     *
     * @param CMSArticle $article
     */
    private function incremetArticleViews(CMSArticle $article)
    {
        $article->setViews($article->getViews()+1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
    }

    /**
     * Get article
     *
     * @param string $slug
     * @return object
     */
    private function getArticle($slug)
    {
        $article = $this->getDoctrine()->getRepository('MyCMSBundle:CMSArticle')
            ->getArticleBySlug($slug);

        if (null == $article) {
            throw $this->createNotFoundException();
        }

        return $article;
    }

    /**
     * Get menus
     *
     * @param string $locale
     * @return object
     */
    private function getMenus($locale)
    {
        $menus = [];

        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('MyCMSBundle:CMSMenu')->getPublicMenus($locale);
        foreach ($menus as $menu) {
            $series = $menu->getSeries()->getName();
            $id = $menu->getId();

            if (is_object($menu->getMenu())) {
                if ($menu->getMenu()->getIsPublic())
                {
                    $parentId = $menu->getMenu()->getId();

                    $menus[$series][$parentId]['childrens'][$id]['parent'] = $menu;
                }
            }
            else {
                $menus[$series][$id]['parent'] = $menu;
            }
        }

        return $menus;
    }

    /**
     * Get metadata by locale
     *
     * @param string $locale
     * @return object
     */
    private function getMetadataByLocale($locale)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:CMSWebSite')
            ->getWebsiteByLocale($locale);
    }

    /**
     * Get public languages
     *
     * @return array
     */
    private function getLanguages()
    {
        $languages = $this->getDoctrine()->getRepository('MyCMSBundle:CMSLanguage')
            ->getPublicLanguages();

        if (count($languages) == 0) {
            throw $this->createNotFoundException();
        }

        return $languages;
    }

    /**
     * Check avilable locales
     *
     * @param object $languages
     * @param string $locale
     * @return boolean
     */
    private function checkAvilableLocales($languages, $locale)
    {
        $avilableLocales = $this->getAvilableLocales($languages);
        if (!in_array($locale, $avilableLocales)) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Get avilable locales
     *
     * @param object $languages
     * @return array
     */
    private function getAvilableLocales($languages)
    {
        $avilableLocales = [];

        foreach ($languages as $language) {
            $avilableLocales[] = strtolower($language->getAlias());
        }

        return $avilableLocales;
    }
}
