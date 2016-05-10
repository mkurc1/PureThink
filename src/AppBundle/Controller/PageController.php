<?php

namespace AppBundle\Controller;

use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;
use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Site;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PageController extends Controller
{
    /**
     * @Route("/", name="page")
     * @Method("GET")
     * @I18nDoctrine
     */
    public function mainAction(Request $request)
    {
        $locale = $request->getLocale();

        if (null == $locale) {
            $availableLocales = $this->get('app.language_service')->getAvailableLocales();
            $request->setLocale($request->getPreferredLanguage($availableLocales));
        }

        return $this->redirectToRoute('localized_page', compact('locale'));
    }

    /**
     * @Route("/{locale}", name="localized_page")
     * @Method("GET")
     * @I18nDoctrine
     */
    public function indexAction(Request $request, $locale)
    {
        if ($this->get('app.language_service')->hasAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        /** @var Site $meta */
        $meta = $this->getMetadataByLocale($locale);

        return $this->render(':Page:index.html.twig', compact('meta'));
    }

    /**
     * @Route("/{locale}/search")
     * @Method("GET")
     * @I18nDoctrine
     */
    public function searchListAction(Request $request, $locale)
    {
        if ($this->get('app.language_service')->hasAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        /** @var Site $meta */
        $meta = $this->getMetadataByLocale($locale);

        if ($search = $request->query->get('query')) {
            $entities = $this->getDoctrine()
                ->getRepository('AppBundle:Article')
                ->searchResults($locale, $search);
        } else {
            $entities = null;
        }

        return $this->render(':Page:searchList.html.twig', compact('meta', 'entities'));
    }

    /**
     * @Route("/{locale}/{slug}", name="article")
     * @ParamConverter("article", class="AppBundle:Article", options={
     *     "repository_method" = "articleBySlug",
     *     "map_method_signature" = true
     * })
     * @Method("GET")
     * @I18nDoctrine
     */
    public function articleAction(Request $request, $locale, Article $article)
    {
        if ($this->get('app.language_service')->hasAvailableLocales($locale)) {
            $request->setLocale($locale);
        } else {
            return $this->getRedirectToMainPage();
        }

        $this->getDoctrine()->getRepository('AppBundle:ArticleView')->incrementViews($article->getViews());

        return $this->render(':Page:article.html.twig', compact('article'));
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
     * @return Site
     */
    private function getMetadataByLocale($locale)
    {
        return $this->getDoctrine()
            ->getRepository('AppBundle:Site')
            ->getSiteByLocale($locale);
    }
}
