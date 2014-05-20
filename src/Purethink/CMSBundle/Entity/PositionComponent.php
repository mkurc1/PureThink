<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PositionComponent extends Position
{
    const SERVICE = 'purethink.cms.block.component';

    /**
     * @ORM\ManyToOne(targetEntity="Component")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Assert\NotNull()
     */
    private $component;


    public function getPositionSlug()
    {
        return $this->getComponent()->getSlug();
    }

    public function getService()
    {
        return self::SERVICE;
    }

    public function getName()
    {
        return $this->getComponent()->getName();
    }

    public function getType()
    {
        return 'Component';
    }

    /**
     * Set component
     *
     * @param \Purethink\CMSBundle\Entity\Component $component
     * @return PositionComponent
     */
    public function setComponent(\Purethink\CMSBundle\Entity\Component $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \Purethink\CMSBundle\Entity\Component 
     */
    public function getComponent()
    {
        return $this->component;
    }
}
