<?php

namespace My\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use My\CMSBundle\Entity\Article;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="frontend")
     * @Method("GET")
     */
    public function mainAction(Request $request)
    {
        $locale = $request->getLocale();

        if (null == $locale) {
            $languages = $this->getLanguages();
            $avilableLocales = $this->getAvilableLocales($languages);

            $locale = $request->getPreferredLanguage($avilableLocales);
            $request->setLocale($locale);
        }

        return $this->redirect($this->generateUrl('localized_frontend', compact('locale')));
    }

    /**
     * Get component Action
     *
     * @param  Request $request
     * @param  stirng  $slug
     * @param  string  $template
     * @return array
     */
    public function componentAction(Request $request, $slug, $template)
    {
        $locale = $request->getLocale();

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentOnPageHasValue')
            ->getActiveComponentBySlugAndLocale($slug, $locale);

        if (count($entities) == 0) {
            return new Response();
        }

        return $this->render($template, compact('entities', 'locale'));
    }

    /**
     * Get menu Action
     *
     * @param  Request $request
     * @param  string  $slug
     * @param  boolean $home
     * @param  boolean $login
     * @return array
     */
    public function menuAction(Request $request, $slug, $home = false, $login = false)
    {
        $locale = $request->getLocale();

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:Menu')
            ->getActiveMenusBySlugAndLocale($slug, $locale);

        if (count($entities) == 0) {
            return new Response();
        }

        return $this->render('MyCMSBundle:Frontend:_menu.html.twig',
            compact('entities', 'locale', 'home', 'login'));
    }

    /**
     * @Route("/{locale}", name="localized_frontend")
     * @Method("GET")
     * @Template()
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
        $request->setLocale($locale);

        $meta = $this->getMetadataByLocale($locale);

        return compact('locale', 'meta', 'languages');
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

        $search = $request->get('article');

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('MyCMSBundle:Article')->search($locale, $search);

        return compact('locale', 'meta', 'languages', 'articles');
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

        return compact('locale', 'languages', 'article', 'url');
    }

    private function incremetArticleViews(Article $article)
    {
        $article->setViews($article->getViews()+1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
    }

    private function getArticle($slug)
    {
        $article = $this->getDoctrine()->getRepository('MyCMSBundle:Article')
            ->getArticleBySlug($slug);

        if (null == $article) {
            throw $this->createNotFoundException();
        }

        return $article;
    }

    private function getMetadataByLocale($locale)
    {
        return $this->getDoctrine()->getRepository('MyCMSBundle:WebSite')
            ->getWebsiteByLocale($locale);
    }

    /**
     * Get public languages
     *
     * @return array
     */
    private function getLanguages()
    {
        $languages = $this->getDoctrine()->getRepository('MyCMSBundle:Language')
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
