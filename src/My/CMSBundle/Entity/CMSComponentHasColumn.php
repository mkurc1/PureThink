<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $columnLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     *
     * @Assert\Length(max="255")
     */
    private $class;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_required", type="boolean", nullable=true)
     */
    private $isRequired = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_main_field", type="boolean", nullable=true)
     */
    private $isMainField = false;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponent")
     * @ORM\JoinColumn(name="component_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $component;

    /**
     * @ORM\Column(name="column_type", type="integer")
     *
     * @Assert\NotNull()
     */
    private $columnType;


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
