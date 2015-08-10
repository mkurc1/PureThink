<?php

namespace Purethink\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

        return $this->redirectToRoute('localized_page', compact('locale'));
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

        /** @var Website $meta */
        $meta = $this->getMetadataByLocale($locale);
        if ($meta) {
            $analytics = $meta->getAnalytics();
        }

        $content = $this->renderView('@PurethinkCMS/Page/index.html.twig',
            compact('meta', 'analytics')
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

        /** @var Website $meta */
        $meta = $this->getMetadataByLocale($locale);
        if ($meta) {
            $analytics = $meta->getAnalytics();
        }

        if ($search = $request->query->get('query')) {
            $entities = $this->getDoctrine()
                ->getRepository('PurethinkCMSBundle:Article')
                ->searchResults($locale, $search);
        } else {
            $entities = null;
        }

        $content = $this->renderView('@PurethinkCMS/Page/searchList.html.twig',
            compact('meta', 'entities', 'analytics')
        );

        return new Response($content);
    }

    /**
     * @Route("/{locale}/{slug}", name="article")
     * @Method("GET")
     */
    public function articleAction(Request $request, $locale, $slug)
    {
        if ($this->get('purethink.cms.language_service')->hasAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        $article = $this->get('purethink.cms.article_service')->getArticleBySlug($slug);
        /** @var Website $meta */
        $meta = $this->getMetadataByLocale($locale);
        if ($meta) {
            $analytics = $meta->getAnalytics();
        }

        $content = $this->renderView('@PurethinkCMS/Page/article.html.twig',
            compact('article', 'analytics')
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
}
