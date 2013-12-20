<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponentOnPage", inversedBy="cmsComponentOnPageHasValue")
     * @ORM\JoinColumn(name="component_on_page_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $componentOnPage;

    /**
     * @ORM\ManyToOne(targetEntity="CMSComponentHasColumn", inversedBy="cmsComponentOnPageHasValue")
     * @ORM\JoinColumn(name="component_has_column_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $componentHasColumn;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CMSComponentOnPageHasValue
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return CMSComponentOnPageHasValue
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set componentOnPage
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPage $componentOnPage
     * @return CMSComponentOnPageHasValue
     */
    public function setComponentOnPage(\My\CMSBundle\Entity\CMSComponentOnPage $componentOnPage)
    {
        $this->componentOnPage = $componentOnPage;

        return $this;
    }

    /**
     * Get componentOnPage
     *
     * @return \My\CMSBundle\Entity\CMSComponentOnPage
     */
    public function getComponentOnPage()
    {
        return $this->componentOnPage;
    }

    /**
     * Set componentHasColumn
     *
     * @param \My\CMSBundle\Entity\CMSComponentHasColumn $componentHasColumn
     * @return CMSComponentOnPageHasValue
     */
    public function setComponentHasColumn(\My\CMSBundle\Entity\CMSComponentHasColumn $componentHasColumn)
    {
        $this->componentHasColumn = $componentHasColumn;

        return $this;
    }

    /**
     * Get componentHasColumn
     *
     * @return \My\CMSBundle\Entity\CMSComponentHasColumn
     */
    public function getComponentHasColumn()
    {
        return $this->componentHasColumn;
    }
}