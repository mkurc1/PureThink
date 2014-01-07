<?php

namespace My\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="frontend")
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
     * @Template()
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

        return array(
            'locale' => $locale,
            'meta' => $meta,
            'languages' => $languages,
            'menus' => $menus,
            'components' => $components
            );
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
     * @Route("/{locale}/{slug}/{slug2}", name="article")
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

        return array(
            'locale' => $locale,
            'languages' => $languages,
            'menus' => $menus,
            'components' => $components,
            'article' => $article
            );
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

        foreach ($entities as $entity) {
            $series = $entity->getSeries()->getName();
            $id = $entity->getId();

            if (is_object($entity->getMenu())) {
                if ($entity->getMenu()->getIsPublic())
                {
                    $parentId = $entity->getMenu()->getId();

                    $menus[$series][$parentId]['childrens'][$id]['parent'] = $entity;
                }
            }
            else {
                $menus[$series][$id]['parent'] = $entity;
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
                    $content = $em->getRepository('MyCMSBundle:CMSArticle')
                        ->find((int)$content)->getSlug();
                    break;
                case 'File':
                    $content = $em->getRepository('MyFileBundle:File')
                        ->find((int)$content)->getPath();
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
