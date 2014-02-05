<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSLayout
 *
 * @ORM\Table(name="cms_layout")
 * @ORM\Entity
 */
class CMSLayout
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
     * @ORM\ManyToOne(targetEntity="CMSTemplate", inversedBy="cmsLayouts")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $template;

    /**
     * @ORM\ManyToOne(targetEntity="CMSLayoutType", inversedBy="cmsLayouts")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $type;


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
     * @return CMSLayout
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
     * @return CMSLayout
     */
    public function setTemplate(\My\CMSBundle\Entity\CMSTemplate $template)
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

    /**
     * Set type
     *
     * @param \My\CMSBundle\Entity\CMSLayoutType $type
     * @return CMSLayout
     */
    public function setType(\My\CMSBundle\Entity\CMSLayoutType $type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \My\CMSBundle\Entity\CMSLayoutType 
     */
    public function getType()
    {
        return $this->type;
    }
}
