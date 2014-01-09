<?php

namespace My\CMSBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use My\CMSBundle\Entity\CMSLanguage;
use My\CMSBundle\Entity\CMSWebSite;
use My\CMSBundle\Entity\CMSArticle;
use My\CMSBundle\Entity\CMSMenu;
use My\CMSBundle\Entity\CMSComponent;
use My\CMSBundle\Entity\CMSComponentHasColumn;
use My\CMSBundle\Entity\CMSComponentOnPage;
use My\CMSBundle\Entity\CMSComponentOnPageHasElement;
use My\CMSBundle\Entity\CMSComponentOnPageHasValue;
use My\CMSBundle\Entity\CMSLayoutType;

class LoadData implements FixtureInterface
{
	/**
	 * Load
	 *
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{
		$manager = $this->addCMSLanguage($manager);
		$manager = $this->addCMSWebSite($manager);
		$manager = $this->addCMSArticle($manager);
		$manager = $this->addCMSMenu($manager);
		$manager = $this->addCMSComponent($manager);
		$manager = $this->addCMSComponentHasColumn($manager);
		$manager = $this->addCMSComponentOnPage($manager);
		$manager = $this->addCMSComponentOnPageHasElement($manager);
		$manager = $this->addCMSComponentOnPageHasValue($manager);
		$manager = $this->addCMSLayoutType($manager);
	}

	/**
	 * Add CMS language fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSLanguage(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsLanguages.xml');
		foreach ($xml->language as $language) {
			$CMSLanguage = new CMSLanguage();
			$CMSLanguage->setName($language->name);
			$CMSLanguage->setAlias($language->alias);
			$CMSLanguage->setIsPublic($language->is_public);

			$manager->persist($CMSLanguage);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS website fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSWebSite(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsWebSites.xml');
		foreach ($xml->webSite as $webSite) {
			$CMSWebSite = new CMSWebSite();
			$CMSWebSite->setName($webSite->name);
			$CMSWebSite->setDescription($webSite->description);
			$CMSWebSite->setKeywords($webSite->keywords);
			$CMSWebSite->setLanguage($manager->getRepository('MyCMSBundle:CMSLanguage')->find($webSite->language_id));

			$manager->persist($CMSWebSite);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS article fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSArticle(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsArticles.xml');
		for ($i=0; $i<5; $i++) {
			foreach ($xml->cmsArticle as $cmsArticle) {
				$CMSArticle = new CMSArticle();
				$CMSArticle->setName($cmsArticle->name);
				$CMSArticle->setDescription($cmsArticle->description);
				$CMSArticle->setKeywords($cmsArticle->keywords);
				$CMSArticle->setIsPublic($cmsArticle->is_public);
				$CMSArticle->setContent($cmsArticle->content);
				$CMSArticle->setLanguage($manager->getRepository('MyCMSBundle:CMSLanguage')->find($cmsArticle->language_id));
				$CMSArticle->setUser($manager->getRepository('MyUserBundle:User')->find($cmsArticle->user_id));
				$CMSArticle->setSeries($manager->getRepository('MyBackendBundle:Series')->find($cmsArticle->series_id));

				$manager->persist($CMSArticle);
			}
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS menu fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSMenu(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsMenus.xml');
		foreach ($xml->cmsMenu as $cmsMenu) {
			$CMSMenu = new CMSMenu();
			$CMSMenu->setName($cmsMenu->name);
			$CMSMenu->setSequence($cmsMenu->sequence);
			$CMSMenu->setIsPublic($cmsMenu->is_public);
			$CMSMenu->setLanguage($manager->getRepository('MyCMSBundle:CMSLanguage')->find($cmsMenu->language_id));
			$CMSMenu->setSeries($manager->getRepository('MyBackendBundle:Series')->find($cmsMenu->series_id));
			$CMSMenu->setArticle($manager->getRepository('MyCMSBundle:CMSArticle')->find($cmsMenu->article_id));
			$CMSMenu->setMenu($manager->getRepository('MyCMSBundle:CMSMenu')->find($cmsMenu->menu_id));

			$manager->persist($CMSMenu);
			$manager->flush();
		}

		return $manager;
	}

	/**
	 * Add CMS component fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSComponent(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsComponents.xml');
		foreach ($xml->cmsComponent as $cmsComponent) {
			$CMSComponent = new CMSComponent();
			$CMSComponent->setName($cmsComponent->name);
			$CMSComponent->setSeries($manager->getRepository('MyBackendBundle:Series')->find($cmsComponent->series_id));

			$manager->persist($CMSComponent);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS component has column fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSComponentHasColumn(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsComponentHasColumns.xml');
		foreach ($xml->cmsComponentHasColumn as $cmsComponentHasColumn) {
			$CMSComponentHasColumn = new CMSComponentHasColumn();
			$CMSComponentHasColumn->setName($cmsComponentHasColumn->name);
			$CMSComponentHasColumn->setColumnLabel($cmsComponentHasColumn->column_label);
			$CMSComponentHasColumn->setClass($cmsComponentHasColumn->class);
			$CMSComponentHasColumn->setIsRequired($cmsComponentHasColumn->is_required);
			$CMSComponentHasColumn->setIsMainField($cmsComponentHasColumn->is_main_field);
			$CMSComponentHasColumn->setComponent($manager->getRepository('MyCMSBundle:CMSComponent')->find($cmsComponentHasColumn->component_id));
			$CMSComponentHasColumn->setColumnType($manager->getRepository('MyBackendBundle:ColumnType')->find($cmsComponentHasColumn->type_id));

			$manager->persist($CMSComponentHasColumn);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS component on page fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSComponentOnPage(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsComponentOnPages.xml');
		foreach ($xml->cmsComponentOnPage as $cmsComponentOnPage) {
			$CMSComponentOnPage = new CMSComponentOnPage();
			$CMSComponentOnPage->setName($cmsComponentOnPage->name);
			$CMSComponentOnPage->setIsEnable($cmsComponentOnPage->is_enable);
			$CMSComponentOnPage->setComponent($manager->getRepository('MyCMSBundle:CMSComponent')->find($cmsComponentOnPage->component_id));
			$CMSComponentOnPage->setLanguage($manager->getRepository('MyCMSBundle:CMSLanguage')->find($cmsComponentOnPage->language_id));
			$CMSComponentOnPage->setSeries($manager->getRepository('MyBackendBundle:Series')->find($cmsComponentOnPage->series_id));

			$manager->persist($CMSComponentOnPage);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS component on page has element fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSComponentOnPageHasElement(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsComponentOnPageHasElements.xml');
		foreach ($xml->cmsComponentOnPageHasElement as $cmsComponentOnPageHasElement) {
			$CMSComponentOnPageHasElement = new CMSComponentOnPageHasElement();
			$CMSComponentOnPageHasElement->setIsEnable($cmsComponentOnPageHasElement->is_enable);
			$CMSComponentOnPageHasElement->setComponentOnPage($manager->getRepository('MyCMSBundle:CMSComponentOnPage')->find($cmsComponentOnPageHasElement->component_on_page_id));

			$manager->persist($CMSComponentOnPageHasElement);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS component on page has value fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSComponentOnPageHasValue(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsComponentOnPageHasValues.xml');
		foreach ($xml->cmsComponentOnPageHasValue as $cmsComponentOnPageHasValue) {
			$CMSComponentOnPageHasValue = new CMSComponentOnPageHasValue();
			$CMSComponentOnPageHasValue->setContent((string)$cmsComponentOnPageHasValue->content);
			$CMSComponentOnPageHasValue->setComponentOnPageHasElement($manager->getRepository('MyCMSBundle:CMSComponentOnPageHasElement')->find($cmsComponentOnPageHasValue->component_on_page_has_element_id));
			$CMSComponentOnPageHasValue->setComponentHasColumn($manager->getRepository('MyCMSBundle:CMSComponentHasColumn')->find($cmsComponentOnPageHasValue->component_has_column_id));

			$manager->persist($CMSComponentOnPageHasValue);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add CMS layout type fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addCMSLayoutType(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/CMSBundle/data/cmsLayoutTypes.xml');
		foreach ($xml->cmsLayoutType as $cmsLayoutType) {
			$CMSLayoutType = new CMSLayoutType();
			$CMSLayoutType->setName($cmsLayoutType->name);

			$manager->persist($CMSLayoutType);
		}

		$manager->flush();
		return $manager;
	}
}