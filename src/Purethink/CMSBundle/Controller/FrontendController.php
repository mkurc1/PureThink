<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\CMSBundle\Entity\Layout;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Purethink\CMSBundle\Entity\Article;
use Purethink\CMSBundle\Entity\Template as CMSTemplate;

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

        $template = $this->getEnabledTemplate();
        $layout = $this->getLayoutForTypeOfTemplate($template, Layout::LAYOUT_MAIN);
        $meta = $this->getMetadataByLocale($locale);

        return compact('meta', 'template', 'layout');
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

        $template = $this->getEnabledTemplate();
        $layout = $this->getLayoutForTypeOfTemplate($template, Layout::LAYOUT_SEARCH);
        $meta = $this->getMetadataByLocale($locale);

        if ($search = $request->query->get('query')) {
            $entities = $this->getDoctrine()
                ->getRepository('PurethinkCMSBundle:Article')
                ->searchResults($locale, $search);
        } else {
            $entities = null;
        }


        return compact('meta', 'entities', 'template', 'layout');
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

        $template = $this->getEnabledTemplate();
        $layout = $this->getLayoutForTypeOfTemplate($template, Layout::LAYOUT_ARTICLE);
        $article = $this->getArticleBySlug($slug);

        return compact('article', 'template', 'layout');
    }

    private function getRedirectToMainPage()
    {
        return $this->redirect($this->generateUrl('frontend'));
    }

    private function getArticleBySlug($slug)
    {
        $article = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Article')
            ->getPublicArticleBySlug($slug);

        if (null == $article) {
            throw $this->createNotFoundException();
        }

        return $article;
    }

    private function getMetadataByLocale($locale)
    {
        return $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Website')
            ->getWebsiteByLocale($locale);
    }

    private function getPublicLanguages()
    {
        $languages = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Language')
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

    private function getLayoutForTypeOfTemplate(CMSTemplate $template, $type)
    {
        return $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Layout')
            ->getLayoutForTypeOfTemplate($template, $type);
    }

    private function getEnabledTemplate()
    {
        $template = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Template')
            ->getEnabledTemplate();

        if (null == $template) {
            throw $this->createNotFoundException();
        }

        return $template;
    }
}
