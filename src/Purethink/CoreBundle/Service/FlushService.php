<?php

namespace Purethink\CoreBundle\Service;

use Doctrine\ORM\EntityManager;

class FlushService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function tryFlush()
    {
        try {
            return $this->flush();
        } catch (\Exception $e) {
            return $this->fail();
        }
    }

    private function flush()
    {
        $this->em->flush();

        return [
            "response" => true,
            "message"  => $this->getSuccessMessage()
        ];
    }

    private function fail()
    {
        return [
            "response" => false,
            "message"  => $this->getFailMessage()
        ];
    }

    private function getSuccessMessage()
    {
        return 'Akcja zakończyła się powodzeniem';
    }

    private function getFailMessage()
    {
        return 'Akcja zakończyła się niepowodzeniem';
    }
}