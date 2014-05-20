<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PositionArticle extends Position
{
    const SERVICE = 'purethink.cms.block.article';


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
        return 'Article';
    }

    public function getType()
    {
        return 'Article';
    }
}
