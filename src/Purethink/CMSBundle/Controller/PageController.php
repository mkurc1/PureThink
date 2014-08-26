<?php

namespace Purethink\CMSBundle\Controller;

use Purethink\CMSBundle\Entity\Layout;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\Template;
use Purethink\CMSBundle\Entity\Website;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            $availableLocales = $this->get('purethink.cms.language_service')->getAvailableLocales();
            $request->setLocale($request->getPreferredLanguage($availableLocales));
        }

        return $this->redirect($this->generateUrl('localized_page', compact('locale')));
    }

    /**
     * @Route("/{locale}", name="localized_page")
     * @Method("GET")
     */
    public function indexAction(Request $request, $locale)
    {
        if ($this->get('purethink.cms.language_service')->hasAvailableLocales($locale)) {
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

        $content = $this->renderView(
            $layout->getAllPath(),
            compact('meta', 'template', 'layout')
        );

        return new Response($content);
    }

    /**
     * @Route("/{locale}/search")
     * @Method("GET")
     */
    public function searchListAction(Request $request, $locale)
    {
        if ($this->get('purethink.cms.language_service')->hasAvailableLocales($locale)) {
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

        $content = $this->renderView(
            $layout->getAllPath(),
            compact('meta', 'entities', 'template', 'layout')
        );

        return new Response($content);
    }

    /**
     * @Route("/{locale}/{category}/{slug}", name="article")
     * @Method("GET")
     */
    public function articleAction(Request $request, $locale, $category, $slug)
    {
        if ($this->get('purethink.cms.language_service')->hasAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        /** @var Template $template */
        $template = $this->getEnabledTemplate();
        /** @var Layout $layout */
        $layout = $this->getLayoutForTypeOfTemplate($template, Layout::LAYOUT_ARTICLE);
        $article = $this->get('purethink.cms.article_service')->getArticleBySlug($slug);

        $content = $this->renderView(
            $layout->getAllPath(),
            compact('article', 'template', 'layout')
        );

        return new Response($content);
    }

    /**
     * @return RedirectResponse
     */
    private function getRedirectToMainPage()
    {
        return $this->redirect($this->generateUrl('page'));
    }

    /**
     * @param string $locale
     * @return Website
     */
    private function getMetadataByLocale($locale)
    {
        return $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Website')
            ->getWebsiteByLocale($locale);
    }

    /**
     * @param Template $template
     * @param string $type
     * @return Layout
     * @throws NotFoundHttpException
     */
    private function getLayoutForTypeOfTemplate(Template $template, $type)
    {
        /** @var Layout $layout */
        $layout = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Layout')
            ->getLayoutForTypeOfTemplate($template, $type);

        if (null == $layout) {
            throw $this->createNotFoundException();
        }

        return $layout;
    }

    /**
     * @return Template
     * @throws NotFoundHttpException
     */
    private function getEnabledTemplate()
    {
        /** @var Template $template */
        $template = $this->getDoctrine()
            ->getRepository('PurethinkCMSBundle:Template')
            ->getEnabledTemplate();

        if (null == $template) {
            throw $this->createNotFoundException();
        }

        return $template;
    }
}
