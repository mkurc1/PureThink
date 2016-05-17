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

class PageController extends Controller
{
    /**
     * @Route("", name="page")
     * @Method("GET")
     * @I18nDoctrine
     */
    public function indexAction(Request $request)
    {
        /** @var Site $meta */
        $meta = $this->getMetadataByLocale($request->getLocale());

        return $this->render(':Page:index.html.twig', compact('meta'));
    }

    /**
     * @Route("/search")
     * @Method("GET")
     * @I18nDoctrine
     */
    public function searchListAction(Request $request)
    {
        $locale = $request->getLocale();

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
     * @Route("/change-locale/{_locale}", name="change_locale")
     * @Method("GET")
     */
    public function changeLocaleAction()
    {
        return $this->redirectToRoute('page');
    }

    /**
     * @Route("/{slug}", name="article")
     * @ParamConverter("article", class="AppBundle:Article", options={
     *     "repository_method" = "articleBySlug",
     *     "map_method_signature" = true
     * })
     * @Method("GET")
     * @I18nDoctrine
     */
    public function articleAction(Article $article)
    {
        $this->getDoctrine()->getRepository('AppBundle:ArticleView')->incrementViews($article->getViews());

        return $this->render(':Page:article.html.twig', compact('article'));
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
