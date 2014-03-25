<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSCSS
 *
 * @ORM\Table(name="cms_css")
 * @ORM\Entity
 */
class CMSCSS
{
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
     * @ORM\ManyToOne(targetEntity="CMSTemplate", inversedBy="cmsCSSs")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    protected $template;


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
     * Set template
     *
     * @param \My\CMSBundle\Entity\CMSTemplate $template
     * @return CMSCSS
     */
    public function setTemplate(\My\CMSBundle\Entity\CMSTemplate $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \My\CMSBundle\Entity\CMSTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
