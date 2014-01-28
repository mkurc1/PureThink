<?php

namespace My\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use My\BackendBundle\Entity\Module;
use My\BackendBundle\Entity\Language;
use My\BackendBundle\Entity\Menu;
use My\BackendBundle\Entity\RowsOnPage;
use My\BackendBundle\Entity\UserSetting;
use My\BackendBundle\Entity\Series;
use My\BackendBundle\Entity\ColumnType;
use My\BackendBundle\Entity\SMTP;

class LoadData implements FixtureInterface
{
	/**
	 * Load
	 *
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{
		$manager = $this->addModules($manager);
		$manager = $this->addLanguages($manager);
		$manager = $this->addMenus($manager);
		$manager = $this->addRowsOnPage($manager);
		$manager = $this->addUserSettings($manager);
		$manager = $this->addSeries($manager);
		$manager = $this->addColumnTypes($manager);
		$manager = $this->addSMTP($manager);
	}

	/**
	 * Add modules fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addModules(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/modules.xml');
		foreach ($xml->module as $module) {
			$Module = new Module();
			$Module->setName($module->name);
			$Module->setIsDefault($module->is_default);

			$manager->persist($Module);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add languages fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addLanguages(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/languages.xml');
		foreach ($xml->language as $language) {
			$Language = new Language();
			$Language->setName($language->name);
			$Language->setAlias($language->alias);
			$Language->setIsDefault($language->is_default);

			$manager->persist($Language);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add menus fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addMenus(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/menus.xml');
		foreach ($xml->menu as $menu) {
			$Menu = new Menu();
			$Menu->setName($menu->name);
			$Menu->setLink($menu->link);
			$Menu->setSequence($menu->sequence);
			$Menu->setModule($manager->getRepository('MyBackendBundle:Module')->find($menu->module_id));

			$manager->persist($Menu);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add rows on page fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addRowsOnPage(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/rowsOnPage.xml');
		foreach ($xml->row as $row) {
			$RowsOnPage = new RowsOnPage();
			$RowsOnPage->setAmount($row->amount);
			$RowsOnPage->setIsDefault($row->is_default);

			$manager->persist($RowsOnPage);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add user settings fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addUserSettings(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/userSettings.xml');
		foreach ($xml->userSetting as $userSetting) {
			$UserSetting = new UserSetting();
			$UserSetting->setUser($manager->getRepository('MyUserBundle:User')->find($userSetting->user_id));
			$UserSetting->setLanguage($manager->getRepository('MyBackendBundle:Language')->find($userSetting->language_id));
			$UserSetting->setModule($manager->getRepository('MyBackendBundle:Module')->find($userSetting->module_id));
			$UserSetting->setRowsOnPage($manager->getRepository('MyBackendBundle:RowsOnPage')->find($userSetting->rows_on_page_id));

			$manager->persist($UserSetting);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add series fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addSeries(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/series.xml');
		foreach ($xml->serie as $series) {
			$Series = new Series();
			$Series->setName($series->name);
			$Series->setMenu($manager->getRepository('MyBackendBundle:Menu')->find($series->menu_id));

			$manager->persist($Series);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add column types fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addColumnTypes(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/columnType.xml');
		foreach ($xml->columnType as $columnType) {
			$ColumnType = new ColumnType();
			$ColumnType->setName($columnType->name);

			$manager->persist($ColumnType);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add SMTP fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addSMTP(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/BackendBundle/data/smtps.xml');
		foreach ($xml->smtp as $smtp) {
			$SMTP = new SMTP();
			$SMTP->setHost($smtp->host);
			$SMTP->setUser($smtp->user);
			$SMTP->setPassword($smtp->password);
			$SMTP->setPort($smtp->port);
			$SMTP->setEncryption($smtp->encryption);

			$manager->persist($SMTP);
		}

		$manager->flush();
		return $manager;
	}
}