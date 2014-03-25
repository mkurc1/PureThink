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
     * @ORM\ManyToOne(targetEntity="ComponentOnPageHasElement", inversedBy="cmsComponentOnPageHasValues")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $componentOnPageHasElement;

    /**
     * @ORM\ManyToOne(targetEntity="ComponentHasColumn")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $componentHasColumn;


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
     * Set componentOnPageHasElement
     *
     * @param \My\CMSBundle\Entity\ComponentOnPageHasElement $componentOnPageHasElement
     * @return ComponentOnPageHasValue
     */
    public function setComponentOnPageHasElement(\My\CMSBundle\Entity\ComponentOnPageHasElement $componentOnPageHasElement)
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
     * Set componentHasColumn
     *
     * @param \My\CMSBundle\Entity\ComponentHasColumn $componentHasColumn
     * @return ComponentOnPageHasValue
     */
    public function setComponentHasColumn(\My\CMSBundle\Entity\ComponentHasColumn $componentHasColumn)
    {
        $this->componentHasColumn = $componentHasColumn;

        return $this;
    }

    /**
     * Get componentHasColumn
     *
     * @return \My\CMSBundle\Entity\ComponentHasColumn
     */
    public function getComponentHasColumn()
    {
        return $this->componentHasColumn;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getContent();
    }
}
