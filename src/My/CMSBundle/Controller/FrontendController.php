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
            $request->setLocale($request->getPreferredLanguage($this->getAvilableLocales()));
        }

        return $this->redirect($this->generateUrl('localized_frontend', compact('locale')));
    }

    /**
     * @Template()
     */
    public function languageAction(Request $request)
    {
        $locale = $request->getLocale();
        $languages = $this->getPublicLanguages();

        return compact('languages', 'locale');
    }

    public function componentAction(Request $request, $slug, $template)
    {
        $locale = $request->getLocale();

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:ComponentHasValue')
            ->getActiveComponentBySlugAndLocale($slug, $locale);

        if (null == $entities) {
            return new Response();
        }

        return $this->render($template, compact('entities', 'locale'));
    }

    /**
     * @Template()
     */
    public function menuAction(Request $request, $slug, $home = false, $login = false)
    {
        $locale = $request->getLocale();

        $entities = $this->getDoctrine()->getRepository('MyCMSBundle:Menu')
            ->getActiveMenusBySlugAndLocale($slug, $locale);

        if (null == $entities) {
            return new Response();
        }

        return compact('entities', 'locale', 'home', 'login');
    }

    /**
     * @Route("/{locale}", name="localized_frontend")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request, $locale)
    {
        if ($this->isAvilableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        $meta = $this->getMetadataByLocale($locale);

        return compact('locale', 'meta');
    }

    /**
     * @Template()
     */
    public function SearchAction(Request $request)
    {
        $locale = $request->getLocale();

        return compact('locale');
    }

    /**
     * @Route("/{locale}/search")
     * @Method("GET")
     * @Template()
     */
    public function searchListAction(Request $request, $locale)
    {
        if ($this->isAvilableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        $meta = $this->getMetadataByLocale($locale);

        $search = $request->get('query');

        $articles = $this->getDoctrine()->getRepository('MyCMSBundle:Article')
            ->search($locale, $search);

        return compact('locale', 'meta', 'articles');
    }

    /**
     * @Route("/{locale}/{slug}/{slug2}", name="article")
     * @Method("GET")
     * @Template()
     */
    public function articleAction(Request $request, $locale, $slug, $slug2 = null)
    {
        if ($this->isAvilableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        if (null == $slug2) {
            $article = $this->getArticleBySlug($slug);
        } else {
            $article = $this->getArticleBySlug($slug2);
        }

        $this->incremetArticleViews($article);

        return compact('locale', 'article');
    }

    private function getRedirectToMainPage()
    {
        return $this->redirect($this->generateUrl('frontend'));
    }

    private function incremetArticleViews(Article $article)
    {
        $article->setViews($article->getViews() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->flush();
    }

    private function getArticleBySlug($slug)
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

    private function getPublicLanguages()
    {
        $languages = $this->getDoctrine()->getRepository('MyCMSBundle:Language')
            ->getPublicLanguages();

        if (null == $languages) {
            throw $this->createNotFoundException();
        }

        return $languages;
    }

    private function isAvilableLocales($locale)
    {
        return (bool)(in_array($locale, $this->getAvilableLocales()));
    }

    private function getAvilableLocales()
    {
        $avilableLocales = [];

        $languages = $this->getPublicLanguages();
        foreach ($languages as $language) {
            $avilableLocales[] = strtolower($language->getAlias());
        }

        return $avilableLocales;
    }
}
