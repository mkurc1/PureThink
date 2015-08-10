<?php

namespace Purethink\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Purethink\CMSBundle\Entity\Website;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

        return $this->render('@PurethinkCMS/Page/index.html.twig', compact('meta'));
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

        if ($search = $request->query->get('query')) {
            $entities = $this->getDoctrine()
                ->getRepository('PurethinkCMSBundle:Article')
                ->searchResults($locale, $search);
        } else {
            $entities = null;
        }

        return $this->render('@PurethinkCMS/Page/searchList.html.twig', compact('meta', 'entities'));
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

        return $this->render('@PurethinkCMS/Page/article.html.twig', compact('article'));
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
