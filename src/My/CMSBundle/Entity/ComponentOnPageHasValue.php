<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cms_component_on_page_has_value")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\ComponentOnPageHasValueRepository")
 */
class ComponentOnPageHasValue
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
     * @ORM\ManyToOne(targetEntity="ComponentOnPageHasElement", inversedBy="componentOnPageHasValues")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $componentOnPageHasElement;

    /**
     * @ORM\ManyToOne(targetEntity="ExtensionHasField")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $extensionHasField;


    public function __construct(ComponentOnPageHasElement $componentOnPageHasElement = null, ExtensionHasField $extensionHasField = null)
    {
        $this->setComponentOnPageHasElement($componentOnPageHasElement);
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
     * @return ComponentOnPageHasValue
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
     * Set componentOnPageHasElement
     *
     * @param \My\CMSBundle\Entity\ComponentOnPageHasElement $componentOnPageHasElement
     * @return ComponentOnPageHasValue
     */
    public function setComponentOnPageHasElement(\My\CMSBundle\Entity\ComponentOnPageHasElement $componentOnPageHasElement = null)
    {
        $this->componentOnPageHasElement = $componentOnPageHasElement;

        return $this;
    }

    /**
     * Get componentOnPageHasElement
     *
     * @return \My\CMSBundle\Entity\ComponentOnPageHasElement 
     */
    public function getComponentOnPageHasElement()
    {
        return $this->componentOnPageHasElement;
    }

    /**
     * Set extensionHasField
     *
     * @param \My\CMSBundle\Entity\ExtensionHasField $extensionHasField
     * @return ComponentOnPageHasValue
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
