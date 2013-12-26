<?php

namespace My\FileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use My\FileBundle\Entity\File;

class LoadData implements FixtureInterface
{
    /**
     * Load
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manager = $this->addFile($manager);
    }

    /**
     * Add File fixtures
     *
     * @param ObjectManager $manager
     */
    private function addFile(ObjectManager $manager)
    {
        $xml = simplexml_load_file('src/My/FileBundle/data/files.xml');
        foreach ($xml->file as $file) {
            $File = new File();
            $File->setName($file->name);
            $File->setSize($file->size);
            $File->setPath($file->path);
            $File->setUser($manager->getRepository('MyUserBundle:User')->find($file->user_id));
            $File->setSeries($manager->getRepository('MyBackendBundle:Series')->find($file->series_id));

            $manager->persist($File);
        }

        $manager->flush();
        return $manager;
    }
}