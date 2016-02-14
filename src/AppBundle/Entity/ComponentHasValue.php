<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="cms_component_has_value")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
abstract class ComponentHasValue implements SoftDeleteable
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ComponentHasElement", inversedBy="componentHasValues")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $componentHasElement;

    /**
     * @ORM\ManyToOne(targetEntity="ExtensionHasField")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $extensionHasField;


    abstract public function getContent();

    abstract public function getStringContent();

    abstract public function setContent($content);

    public function __toString()
    {
        return (string)$this->getStringContent();
    }

    public function __construct(ComponentHasElement $componentHasElement = null, ExtensionHasField $extensionHasField = null)
    {
        $this->setComponentHasElement($componentHasElement);
        $this->setExtensionHasField($extensionHasField);
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
     * Set componentHasElement
     *
     * @param ComponentHasElement $componentHasElement
     * @return ComponentHasValue
     */
    public function setComponentHasElement(ComponentHasElement $componentHasElement = null)
    {
        $this->componentHasElement = $componentHasElement;

        return $this;
    }

    /**
     * Get componentHasElement
     *
     * @return ComponentHasElement
     */
    public function getComponentHasElement()
    {
        return $this->componentHasElement;
    }

    /**
     * Set extensionHasField
     *
     * @param ExtensionHasField $extensionHasField
     * @return ComponentHasValue
     */
    public function setExtensionHasField(ExtensionHasField $extensionHasField = null)
    {
        $this->extensionHasField = $extensionHasField;

        return $this;
    }

    /**
     * Get extensionHasField
     *
     * @return ExtensionHasField
     */
    public function getExtensionHasField()
    {
        return $this->extensionHasField;
    }
}
