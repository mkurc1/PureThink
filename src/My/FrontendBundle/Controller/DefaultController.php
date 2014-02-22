<?php

namespace My\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="frontend")
     * @Method("GET")
     */
    public function mainAction(Request $request)
    {
        $languages = $this->getLanguages();
        $avilableLocales = $this->getAvilableLocales($languages);

        $locale = $request->getPreferredLanguage($avilableLocales);

        return $this->redirect($this->generateUrl('localized_frontend', array('locale' => $locale)));
    }

    /**
     * @Route("/{locale}", name="localized_frontend")
     * @Method("GET")
     * @Template()
     * @Cache(maxage="3600")
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

        $meta = $this->getMeta($locale);
        $menus = $this->getMenus($locale);
        $components = $this->getComponents($locale);

        return compact('locale', 'meta', 'languages', 'menus', 'components');
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
        $avilableLocales = array();

        foreach ($languages as $language) {
            $avilableLocales[] = strtolower($language->getAlias());
        }

        return $avilableLocales;
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

        $meta = $this->getMeta($locale);
        $menus = $this->getMenus($locale);
        $components = $this->getComponents($locale);

        $search = $request->get('article');

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('MyCMSBundle:CMSArticle')->search($locale, $search);

        return compact('locale', 'meta', 'languages', 'menus', 'components', 'articles');
    }

    /**
     * @Route("/{locale}/{slug}/{slug2}", name="article")
     * @Method("GET")
     * @Template()
     */
    public function articleAction(Request $request, $locale, $slug, $slug2 = false)
    {
        $languages = $this->getLanguages();
        if ($this->checkAvilableLocales($languages, $locale)) {
            $request->setLocale($locale);
        }
        else {
            return $this->redirect($this->generateUrl('frontend'));
        }

        $menus = $this->getMenus($locale);
        $components = $this->getComponents($locale);

        if ($slug2) {
            $article = $this->getArticle($slug2);
        }
        else {
            $article = $this->getArticle($slug);
        }

        $url = array(
            'slug'  => $slug,
            'slug2' => $slug2
            );

        return compact('locale', 'languages', 'menus', 'components', 'article', 'url');
    }

    /**
     * Get article
     *
     * @param string $slug
     * @return object
     */
    public function getArticle($slug)
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('MyCMSBundle:CMSArticle')->findOneBySlug($slug);
    }

    /**
     * Get menus
     *
     * @param string $locale
     * @return object
     */
    private function getMenus($locale)
    {
        $menus = array();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSMenu')->getPublicMenus($locale);
        foreach ($entities as $menu) {
            $series = $menu->getSeries()->getName();
            $id = $menu->getId();

            if (is_object($menu->getMenu())) {
                if ($menu->getMenu()->getIsPublic())
                {
                    $parentId = $menu->getMenu()->getId();

                    $menus[$series][$parentId]['childrens'][$id]['parent'] = $menu;
                }
            }
            else {
                $menus[$series][$id]['parent'] = $menu;
            }
        }

        return $menus;
    }

    /**
     * Get components
     *
     * @param string $locale
     * @return array
     */
    private function getComponents($locale)
    {
        $components = array();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyCMSBundle:CMSComponentOnPageHasValue')->getComponents($locale);
        foreach ($entities as $entity) {
            $slug = $entity['slug'];
            $title = $entity['title'];
            $elementId = $entity['elementId'];
            $subname = $entity['subname'];
            $createdAt = $entity['createdAt'];
            $updatedAt = $entity['updatedAt'];
            $content = $entity['content'];

            switch ($entity['type']) {
                case 'Article':
                    $content = $entity['article'];
                    break;
                case 'File':
                    $content = $entity['file'];
                    break;
            }

            $components[$slug]['title'] = $title;
            $components[$slug][$elementId][$subname] = $content;
            $components[$slug][$elementId]['createdAt'] = $createdAt;
            $components[$slug][$elementId]['updatedAt'] = $updatedAt;
        }

        return $components;
    }

    /**
     * Get meta
     *
     * @param string $locale
     * @return object
     */
    private function getMeta($locale)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            return $em->getRepository('MyCMSBundle:CMSWebsite')->getMeta($locale);
        }
        catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get public languages
     *
     * @return array
     */
    private function getLanguages()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('MyCMSBundle:CMSLanguage')->getPublicLanguages();
    }
}
