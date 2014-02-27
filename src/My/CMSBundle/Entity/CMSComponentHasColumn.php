<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CMSComponentHasColumn
 *
 * @ORM\Table(name="cms_component_has_column")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSComponentHasColumnRepository")
 */
class CMSComponentHasColumn
{
    public static $avilableColumnType = [
                                         1  => "Text",
                                         2  => "Textarea",
                                         3  => "Integer",
                                         4  => "Float",
                                         5  => "Double",
                                         6  => "Boolean",
                                         7  => "Date",
                                         8  => "Datetime",
                                         9  => "Article",
                                         10 => "File"
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="column_label", type="string", length=255)
     */
    private $columnLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     */
    private $class;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_required", type="boolean", nullable=true)
     */
    private $isRequired;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_main_field", type="boolean", nullable=true)
     */
    private $isMainField;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponent", inversedBy="cmsComponentHasColumns")
     * @ORM\JoinColumn(name="component_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $component;

    /**
     * @ORM\Column(name="column_type", type="integer")
     */
    private $columnType;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentOnPageHasValue", mappedBy="cmsComponentHasColumns")
     */
    protected $cmsComponentOnPagesHasValues;


    /**
     * Get string column type by ID
     *
     * @param  integer $id
     * @return string
     */
    public static function getColumnTypeStringById($id) {
        return self::$avilableColumnType[$id];
    }

    /**
     * Get string column type
     *
     * @return string
     */
    public function getColumnTypeString()
    {
        return self::$avilableColumnType[$this->getColumnType()];
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
     * Set name
     *
     * @param string $name
     * @return CMSComponentHasColumn
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set columnLabel
     *
     * @param string $columnLabel
     * @return CMSComponentHasColumn
     */
    public function setColumnLabel($columnLabel)
    {
        $this->columnLabel = $columnLabel;

        return $this;
    }

    /**
     * Get columnLabel
     *
     * @return string
     */
    public function getColumnLabel()
    {
        return $this->columnLabel;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return CMSComponentHasColumn
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set isRequired
     *
     * @param boolean $isRequired
     * @return CMSComponentHasColumn
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * Get isRequired
     *
     * @return boolean
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * Set component
     *
     * @param \My\CMSBundle\Entity\CMSComponent $component
     * @return CMSComponentHasColumn
     */
    public function setComponent(\My\CMSBundle\Entity\CMSComponent $component)
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cmsComponentOnPagesHasValues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isMainField = false;
    }

    /**
     * Add cmsComponentOnPagesHasValues
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasValue $cmsComponentOnPagesHasValues
     * @return CMSComponentHasColumn
     */
    public function addCmsComponentOnPagesHasValue(\My\CMSBundle\Entity\CMSComponentOnPageHasValue $cmsComponentOnPagesHasValues)
    {
        $this->cmsComponentOnPagesHasValues[] = $cmsComponentOnPagesHasValues;

        return $this;
    }

    /**
     * Remove cmsComponentOnPagesHasValues
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasValue $cmsComponentOnPagesHasValues
     */
    public function removeCmsComponentOnPagesHasValue(\My\CMSBundle\Entity\CMSComponentOnPageHasValue $cmsComponentOnPagesHasValues)
    {
        $this->cmsComponentOnPagesHasValues->removeElement($cmsComponentOnPagesHasValues);
    }

    /**
     * Get cmsComponentOnPagesHasValues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsComponentOnPagesHasValues()
    {
        return $this->cmsComponentOnPagesHasValues;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return CMSComponentHasColumn
     */
    public function setSlug($slug)
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
     * Set isMainField
     *
     * @param boolean $isMainField
     * @return CMSComponentHasColumn
     */
    public function setIsMainField($isMainField)
    {
        $this->isMainField = $isMainField;

        return $this;
    }

    /**
     * Get isMainField
     *
     * @return boolean
     */
    public function getIsMainField()
    {
        return $this->isMainField;
    }

    /**
     * Set columnType
     *
     * @param integer $columnType
     * @return CMSComponentHasColumn
     */
    public function setColumnType($columnType)
    {
        $this->columnType = $columnType;

        return $this;
    }

    /**
     * Get columnType
     *
     * @return integer
     */
    public function getColumnType()
    {
        return $this->columnType;
    }
}
