<?php

namespace My\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use My\UserBundle\Entity\User;
use My\BackendBundle\Entity\Module;
use My\BackendBundle\Entity\Language;
use My\BackendBundle\Entity\Menu;
use My\BackendBundle\Entity\RowsOnPage;
use My\BackendBundle\Entity\UserSetting;

class LoadData implements FixtureInterface
{
	/**
	 * Load
	 *
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{
		$manager = $this->addUsers($manager);
		$manager = $this->addModules($manager);
		$manager = $this->addLanguages($manager);
		$manager = $this->addMenus($manager);
		$manager = $this->addRowsOnPage($manager);
		$manager = $this->addUserSettings($manager);
	}

	/**
	 * Add users
	 *
	 * @param ObjectManager $manager
	 */
	private function addUsers(ObjectManager $manager)
	{
		$xml = simplexml_load_file('data/users.xml');
		foreach ($xml->user as $user) {
			$User = new User();
			$User->setUsername($user->username);
			$User->setUsernameCanonical($user->username_canonical);
			$User->setEmail($user->email);
			$User->setEmailCanonical($user->email_canonical);
			$User->setEnabled($user->enabled);
			$User->setPlainPassword($user->password);
			$User->setFirstName($user->first_name);
			$User->setLastName($user->last_name);

			foreach ($user->roles->role as $role)
				$User->addRole($role->name);

			$manager->persist($User);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add modules
	 *
	 * @param ObjectManager $manager
	 */
	private function addModules(ObjectManager $manager)
	{
		$xml = simplexml_load_file('data/modules.xml');
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
	 * Add languages
	 *
	 * @param ObjectManager $manager
	 */
	private function addLanguages(ObjectManager $manager)
	{
		$xml = simplexml_load_file('data/languages.xml');
		foreach ($xml->language as $language) {
			$Language = new Language();
			$Language->setName($language->name);
			$Language->setAlias($language->alias);
			$Language->setIsPublic($language->is_public);
			$Language->setIsDefault($language->is_default);

			$manager->persist($Language);
		}

		$manager->flush();
		return $manager;
	}

	/**
	 * Add menus
	 *
	 * @param ObjectManager $manager
	 */
	private function addMenus(ObjectManager $manager)
	{
		$xml = simplexml_load_file('data/menus.xml');
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
	 * Add rows on page
	 *
	 * @param ObjectManager $manager
	 */
	private function addRowsOnPage(ObjectManager $manager)
	{
		$xml = simplexml_load_file('data/rowsOnPage.xml');
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
	 * Add user settings
	 *
	 * @param ObjectManager $manager
	 */
	private function addUserSettings(ObjectManager $manager)
	{
		$xml = simplexml_load_file('data/userSettings.xml');
		foreach ($xml->userSetting as $userSetting) {
			$UserSetting = new UserSetting();
			$UserSetting->setUser($manager->getRepository('MyUserBundle:User')->find($userSetting->user_id));
			$UserSetting->setLanguage($manager->getRepository('MyBackendBundle:Language')->find($userSetting->language_id));
			$UserSetting->setModule($manager->getRepository('MyBackendBundle:Module')->find($userSetting->module_id));
			$UserSetting->setRowsOnPage($manager->getRepository('MyBackendBundle:RowsOnPage')->find($userSetting->rows_on_page_id));
			$UserSetting->setMenu($manager->getRepository('MyBackendBundle:Menu')->find($userSetting->menu_id));

			$manager->persist($UserSetting);
		}

		$manager->flush();
		return $manager;
	}
}