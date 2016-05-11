<?php

namespace AppBundle\Entity;

interface MetadataInterface
{
    public function getTitle();

    public function getDescription();

    public function getKeyword();
}