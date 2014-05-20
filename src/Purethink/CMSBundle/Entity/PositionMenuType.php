<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PositionMenuType extends Position
{
    const SERVICE = 'purethink.cms.block.menu';

    /**
     * @ORM\ManyToOne(targetEntity="MenuType")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $menuType;


    public function getPositionSlug()
    {
        return $this->getMenuType()->getSlug();
    }

    public function getService()
    {
        return self::SERVICE;
    }

    public function getName()
    {
        return $this->getMenuType()->getName();
    }

    public function getType()
    {
        return 'Menu';
    }

    /**
     * Set menuType
     *
     * @param \Purethink\CMSBundle\Entity\MenuType $menuType
     * @return PositionMenuType
     */
    public function setMenuType(\Purethink\CMSBundle\Entity\MenuType $menuType = null)
    {
        $this->menuType = $menuType;

        return $this;
    }

    /**
     * Get menuType
     *
     * @return \Purethink\CMSBundle\Entity\MenuType 
     */
    public function getMenuType()
    {
        return $this->menuType;
    }
}
