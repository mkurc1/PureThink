<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cms_layout")
 * @ORM\Entity
 */
class Layout
{
    private static $avilableType = [
                                    1 => 'Main',
                                    2 => 'Article',
                                    3 => 'Search'
                                   ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="cmsLayouts")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $template;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;


    public static function getAvilableType()
    {
        return self::$avilableType;
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
     * @return Layout
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
     * @param \My\CMSBundle\Entity\Template $template
     * @return Layout
     */
    public function setTemplate(\My\CMSBundle\Entity\Template $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \My\CMSBundle\Entity\Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Layout
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}