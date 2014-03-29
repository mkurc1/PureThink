<?php
namespace My\BackendBundle\Controller;

interface CRUDInterface
{
    public function getListQB(array $params);

    public function getListTemplate();

    public function getEntityById($id);

    public function getEntitiesByIds(array $ids);

    public function getNewEntity();

    public function getForm($entity, $params);

    public function getNewFormTemplate();

    public function getEditFormTemplate();
}