<?php

namespace My\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use My\UserBundle\Entity\User;

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
	}

	/**
	 * Add users fixtures
	 *
	 * @param ObjectManager $manager
	 */
	private function addUsers(ObjectManager $manager)
	{
		$xml = simplexml_load_file('src/My/UserBundle/data/users.xml');
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
}