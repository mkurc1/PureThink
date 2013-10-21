<?php 

namespace My\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use My\UserBundle\Entity\User;
use My\BackendBundle\Entity\Module;
use My\BackendBundle\Entity\Language;
use My\BackendBundle\Entity\Menu;

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
	}

	/**
	 * Add users
	 * 
	 * @param ObjectManager $manager
	 */
	private function addUsers(ObjectManager $manager)
	{
		$xml = simplexml_load_file('data/users.xml');
		foreach ($xml->user as $user)
		{
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
		foreach ($xml->module as $module)
		{
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
		foreach ($xml->language as $language)
		{
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
		foreach ($xml->menu as $menu)
		{
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
}