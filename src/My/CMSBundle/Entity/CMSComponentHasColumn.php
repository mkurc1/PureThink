<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSComponentHasColumn
 *
 * @ORM\Table(name="cms_component_has_column")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSComponentHasColumnRepository")
 */
class CMSComponentHasColumn
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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
     * @ORM\ManyToOne(targetEntity="CMSComponent", inversedBy="cmsComponentHasColumns")
     * @ORM\JoinColumn(name="component_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $component;

    /**
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\ColumnType", inversedBy="cmsComponentHasColumns")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $columnType;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentOnPageHasValue", mappedBy="cmsComponentHasColumns")
     */
    protected $cmsComponentOnPagesHasValues;


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
     * Set columnType
     *
     * @param \My\BackendBundle\Entity\ColumnType $columnType
     * @return CMSComponentHasColumn
     */
    public function setColumnType(\My\BackendBundle\Entity\ColumnType $columnType)
    {
        $this->columnType = $columnType;

        return $this;
    }

    /**
     * Get columnType
     *
     * @return \My\BackendBundle\Entity\ColumnType
     */
    public function getColumnType()
    {
        return $this->columnType;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cmsComponentOnPagesHasValues = new \Doctrine\Common\Collections\ArrayCollection();
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
}