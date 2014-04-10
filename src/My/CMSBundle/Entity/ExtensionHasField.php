<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use My\CMSBundle\Entity\Extension;

/**
 * @ORM\Table(name="cms_extension_has_field")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\ExtensionHasFieldRepository")
 */
class ExtensionHasField
{
    public static $avilableTypeOfField = [
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
     * @Gedmo\Slug(fields={"name"}, unique=false)
     * @ORM\Column(length=255, unique=false)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $labelOfField;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $class;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isRequired = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMainField = false;

    /**
     * @ORM\ManyToOne(targetEntity="Extension")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $extension;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     */
    private $typeOfField;


    public function __construct(Extension $extension = null)
    {
        if (null != $extension) {
            $this->setExtension($extension);
        }
    }

    public static function getTypeOfFieldStringById($id)
    {
        return self::$avilableTypeOfField[$id];
    }

    public function getTypeOfFieldString()
    {
        return self::$avilableTypeOfField[$this->getTypeOfField()];
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
     * @return ExtensionHasField
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
     * Set class
     *
     * @param string $class
     * @return ExtensionHasField
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
     * @return ExtensionHasField
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
     * Set slug
     *
     * @param string $slug
     * @return ExtensionHasField
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
     * @return ExtensionHasField
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
     * Set extension
     *
     * @param \My\CMSBundle\Entity\Extension $extension
     * @return ExtensionHasField
     */
    public function setExtension(\My\CMSBundle\Entity\Extension $extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return \My\CMSBundle\Entity\Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set labelOfField
     *
     * @param string $labelOfField
     * @return ExtensionHasField
     */
    public function setLabelOfField($labelOfField)
    {
        $this->labelOfField = $labelOfField;

        return $this;
    }

    /**
     * Get labelOfField
     *
     * @return string
     */
    public function getLabelOfField()
    {
        return $this->labelOfField;
    }

    /**
     * Set typeOfField
     *
     * @param integer $typeOfField
     * @return ExtensionHasField
     */
    public function setTypeOfField($typeOfField)
    {
        $this->typeOfField = $typeOfField;

        return $this;
    }

    /**
     * Get typeOfField
     *
     * @return integer
     */
    public function getTypeOfField()
    {
        return $this->typeOfField;
    }
}