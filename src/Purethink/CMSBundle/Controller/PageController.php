<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\CMSBundle\Entity\Layout;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\Article;
use Purethink\CMSBundle\Entity\Template;
use Purethink\CMSBundle\Entity\Language;
use Purethink\CMSBundle\Entity\Website;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * @Route("/", name="page")
     * @Method("GET")
     */
    public function mainAction(Request $request)
    {
        $locale = $request->getLocale();

        if (null == $locale) {
            $request->setLocale($request->getPreferredLanguage($this->getAvailableLocales()));
        }

        return $this->redirect($this->generateUrl('localized_page', compact('locale')));
    }

    /**
     * @Route("/{locale}", name="localized_page")
     * @Method("GET")
     */
    public function indexAction(Request $request, $locale)
    {
        if ($this->isAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        /** @var Template $template */
        $template = $this->getEnabledTemplate();
        /** @var Layout $layout */
        $layout = $this->getLayoutForTypeOfTemplate($template, Layout::LAYOUT_MAIN);
        /** @var Website $meta */
        $meta = $this->getMetadataByLocale($locale);

        $content = $this->renderView($layout->getAllPath(),
            compact('meta', 'template', 'layout'));

        return new Response($content);
    }

    /**
     * @Route("/{locale}/search")
     * @Method("GET")
     */
    public function searchListAction(Request $request, $locale)
    {
        if ($this->isAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        /** @var Template $template */
        $template = $this->getEnabledTemplate();
        /** @var Layout $layout */
        $layout = $this->getLayoutForTypeOfTemplate($template, Layout::LAYOUT_SEARCH);
        /** @var Website $meta */
        $meta = $this->getMetadataByLocale($locale);

        if ($search = $request->query->get('query')) {
            $entities = $this->getDoctrine()
                ->getRepository('PurethinkCMSBundle:Article')
                ->searchResults($locale, $search);
        } else {
            $entities = null;
        }

        $content = $this->renderView($layout->getAllPath(),
            compact('meta', 'entities', 'template', 'layout'));

        return new Response($content);
    }

    /**
     * @Route("/{locale}/{slug}", name="article")
     * @Method("GET")
     */
    public function articleAction(Request $request, $locale, $slug)
    {
        if ($this->isAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        /** @var Template $template */
        $template = $this->getEnabledTemplate();
        /** @var Layout $layout */
        $layout = $this->getLayoutForTypeOfTemplate($template, Layout::LAYOUT_ARTICLE);
        /** @var Article $article */
        $article = $this->getArticleBySlug($slug);

        $content = $this->renderView($layout->getAllPath(),
            compact('article', 'template', 'layout'));

        return new Response($content);
    }

    private function getRedirectToMainPage()
    {
        return $this->redirect($this->generateUrl('page'));
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
        /** @var Language $language */
        foreach ($languages as $language) {
            $availableLocales[] = strtolower($language->getAlias());
        }

        return $availableLocales;
    }

    private function getLayoutForTypeOfTemplate(Template $template, $type)
    {
        $layout =  $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Layout')
            ->getLayoutForTypeOfTemplate($template, $type);

        if (null == $layout) {
            throw $this->createNotFoundException();
        }

        return $layout;
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
