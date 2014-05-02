<?php

namespace Purethink\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Purethink\CMSBundle\Entity\Article;

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
            $request->setLocale($request->getPreferredLanguage($this->getAvailableLocales()));
        }

        return $this->redirect($this->generateUrl('localized_frontend', compact('locale')));
    }

    /**
     * @Route("/{locale}", name="localized_frontend")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request, $locale)
    {
        if ($this->isAvailableLocales($locale)) {
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
    public function searchAction(Request $request)
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
        if ($this->isAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        $meta = $this->getMetadataByLocale($locale);

        $search = $request->get('query');

        $articles = $this->getDoctrine()->getRepository('PurethinkCMSBundle:Article')
            ->search($locale, $search);

        return compact('locale', 'meta', 'articles');
    }

    /**
     * @Route("/{locale}/{slug}", name="article")
     * @Method("GET")
     * @Template()
     */
    public function articleAction(Request $request, $locale, $slug)
    {
        if ($this->isAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        $article = $this->getArticleBySlug($slug);

        $this->incrementArticleViews($article);

        return compact('locale', 'article');
    }

    private function getRedirectToMainPage()
    {
        return $this->redirect($this->generateUrl('frontend'));
    }

    private function incrementArticleViews(Article $article)
    {
        $article->incrementArticleViews();

        $this->getDoctrine()->getManager()->flush();
    }

    private function getArticleBySlug($slug)
    {
        $article = $this->getDoctrine()->getRepository('PurethinkCMSBundle:Article')
            ->getPublicArticleBySlug($slug);

        if (null == $article) {
            throw $this->createNotFoundException();
        }

        return $article;
    }

    private function getMetadataByLocale($locale)
    {
        return $this->getDoctrine()->getRepository('PurethinkCMSBundle:Website')
            ->getWebsiteByLocale($locale);
    }

    private function getPublicLanguages()
    {
        $languages = $this->getDoctrine()->getRepository('PurethinkCMSBundle:Language')
            ->getPublicLanguages();

        if (null == $languages) {
            throw $this->createNotFoundException();
        }

        return $languages;
    }

    private function isAvailableLocales($locale)
    {
        return (bool)(in_array($locale, $this->getAvailableLocales()));
    }

    private function getAvailableLocales()
    {
        $availableLocales = [];

        $languages = $this->getPublicLanguages();
        foreach ($languages as $language) {
            $availableLocales[] = strtolower($language->getAlias());
        }

        return $availableLocales;
    }
}
