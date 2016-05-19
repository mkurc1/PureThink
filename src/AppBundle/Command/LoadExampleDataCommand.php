<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadExampleDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('purethink:load_example_data')
            ->setDescription('Load example data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->getFilters()->disable('oneLocale');

        $this->getContainer()->get('khepin.yaml_loader')->purgeDatabase('orm');
        $this->getContainer()->get('khepin.yaml_loader')->loadFixtures();

        $output->writeln('done!');
    }
}