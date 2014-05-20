<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PositionLanguage extends Position
{
    const SERVICE = 'purethink.cms.block.language';


    public function getService()
    {
        return self::SERVICE;
    }

    public function getPositionSlug()
    {
        return null;
    }

    public function getName()
    {
        return 'Language';
    }

    public function getType()
    {
        return 'Language';
    }
}
