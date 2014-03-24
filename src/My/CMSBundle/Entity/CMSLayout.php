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
    private static $avilableType = [
                                    1 => 'Main',
                                    2 => 'Article',
                                    3 => 'Search'
                                   ];

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
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;


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
     * @param integer $type
     * @return CMSLayout
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
