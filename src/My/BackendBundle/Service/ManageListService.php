<?php

namespace My\BackendBundle\Service;

class ManageListService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function deleteEntities($entities)
    {
        foreach ($entities as $entity) {
            $this->em->remove($entity);
        }

        try {
            $this->em->flush();

            $response = array(
                "response" => true,
                "message"  => 'Usuwanie pozycji zakończyło się powodzeniem'
                );
        } catch (\Exception $e) {
            $response = array(
                "response" => false,
                "message"  => 'Usuwanie pozycji zakończyło się niepowodzeniem'
                );
        }

        return $response;
    }
}