<?php

namespace My\CMSBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use My\CMSBundle\Entity\CMSLanguage;
use My\CMSBundle\Entity\CMSWebSite;
use My\CMSBundle\Entity\CMSArticle;

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

				$manager->persist($CMSArticle);
			}
		}

		$manager->flush();
		return $manager;
	}
}