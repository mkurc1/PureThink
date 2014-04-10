<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cms_component_has_value")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\ComponentHasValueRepository")
 */
class ComponentHasValue
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

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


    public function __construct(ComponentHasElement $componentHasElement = null, ExtensionHasField $extensionHasField = null)
    {
        $this->setComponentHasElement($componentHasElement);
        $this->setExtensionHasField($extensionHasField);
    }

    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ComponentHasValue
     */
    public function setContent($content)
    {
        if (is_object($content)) {
            $this->content = $content->getId();
        }
        else {
            $this->content = $content;
        }

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
     * @param \My\CMSBundle\Entity\ComponentHasElement $componentHasElement
     * @return ComponentHasValue
     */
    public function setComponentHasElement(\My\CMSBundle\Entity\ComponentHasElement $componentHasElement = null)
    {
        $this->componentHasElement = $componentHasElement;

        return $this;
    }

    /**
     * Get componentHasElement
     *
     * @return \My\CMSBundle\Entity\ComponentHasElement
     */
    public function getComponentHasElement()
    {
        return $this->componentHasElement;
    }

    /**
     * Set extensionHasField
     *
     * @param \My\CMSBundle\Entity\ExtensionHasField $extensionHasField
     * @return ComponentHasValue
     */
    public function setExtensionHasField(\My\CMSBundle\Entity\ExtensionHasField $extensionHasField = null)
    {
        $this->extensionHasField = $extensionHasField;

        return $this;
    }

    /**
     * Get extensionHasField
     *
     * @return \My\CMSBundle\Entity\ExtensionHasField 
     */
    public function getExtensionHasField()
    {
        return $this->extensionHasField;
    }
}