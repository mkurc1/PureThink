<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSCSS
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CMSCSS
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_frontend", type="boolean")
     */
    private $isFrontend;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponent", inversedBy="cmsCSSs")
     * @ORM\JoinColumn(name="component_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $component;


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
     * @return CMSCSS
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
     * Set isFrontend
     *
     * @param boolean $isFrontend
     * @return CMSCSS
     */
    public function setIsFrontend($isFrontend)
    {
        $this->isFrontend = $isFrontend;

        return $this;
    }

    /**
     * Get isFrontend
     *
     * @return boolean
     */
    public function getIsFrontend()
    {
        return $this->isFrontend;
    }

    /**
     * Set component
     *
     * @param \My\CMSBundle\Entity\CMSComponent $component
     * @return CMSCSS
     */
    public function setComponent(\My\CMSBundle\Entity\CMSComponent $component = null)
    {
        $this->component = $component;
    
        return $this;
    }

    /**
     * Get component
     *
     * @return \My\CMSBundle\Entity\CMSComponent 
     */
    public function getComponent()
    {
        return $this->component;
    }
}