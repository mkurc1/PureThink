<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSComponentOnPageHasValue
 *
 * @ORM\Table(name="cms_component_on_page_has_value")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSComponentOnPageHasValueRepository")
 */
class CMSComponentOnPageHasValue
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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponentOnPageHasElement", inversedBy="cmsComponentOnPageHasValues")
     * @ORM\JoinColumn(name="component_on_page_has_element_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $componentOnPageHasElement;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponentHasColumn", inversedBy="cmsComponentOnPageHasValues")
     * @ORM\JoinColumn(name="component_on_page_has_column_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $componentOnPageHasColumn;


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
     * @return CMSComponentOnPageHasValue
     */
    public function setContent($content)
    {
        $this->content = $content;

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
     * @param \My\CMSBundle\Entity\CMSComponentOnPageHasElement $componentOnPageHasElement
     * @return CMSComponentOnPageHasValue
     */
    public function setComponentOnPageHasElement(\My\CMSBundle\Entity\CMSComponentOnPageHasElement $componentOnPageHasElement)
    {
        $this->componentOnPageHasElement = $componentOnPageHasElement;
    
        return $this;
    }

    /**
     * Get componentOnPageHasElement
     *
     * @return \My\CMSBundle\Entity\CMSComponentOnPageHasElement 
     */
    public function getComponentOnPageHasElement()
    {
        return $this->componentOnPageHasElement;
    }

    /**
     * Set componentOnPageHasColumn
     *
     * @param \My\CMSBundle\Entity\CMSComponentHasColumn $componentOnPageHasColumn
     * @return CMSComponentOnPageHasValue
     */
    public function setComponentOnPageHasColumn(\My\CMSBundle\Entity\CMSComponentHasColumn $componentOnPageHasColumn)
    {
        $this->componentOnPageHasColumn = $componentOnPageHasColumn;
    
        return $this;
    }

    /**
     * Get componentOnPageHasColumn
     *
     * @return \My\CMSBundle\Entity\CMSComponentHasColumn 
     */
    public function getComponentOnPageHasColumn()
    {
        return $this->componentOnPageHasColumn;
    }
}