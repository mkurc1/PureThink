<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="cms_position")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
abstract class Position
{
    const POSITION_SLUG_PREFIX = 'position';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Layout", inversedBy="positions")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $layout;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $path;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;


    abstract function getName();

    abstract function getPositionSlug();

    abstract function getType();

    abstract function getService();

    public function __toString()
    {
        return (string)$this->getSlug();
    }

    /**
     * @ORM\PostPersist
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->setSlug(self::POSITION_SLUG_PREFIX . '-' . $this->getPosition());

        $om = $args->getObjectManager();
        $om->flush($this);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Position
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set template
     *
     * @param \Purethink\CMSBundle\Entity\Template $template
     * @return Position
     */
    public function setTemplate(\Purethink\CMSBundle\Entity\Template $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \Purethink\CMSBundle\Entity\Template 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Position
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Position
     */
    public function setSlug($slug = null)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set layout
     *
     * @param \Purethink\CMSBundle\Entity\Layout $layout
     * @return Position
     */
    public function setLayout(\Purethink\CMSBundle\Entity\Layout $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get layout
     *
     * @return \Purethink\CMSBundle\Entity\Layout 
     */
    public function getLayout()
    {
        return $this->layout;
    }
}
