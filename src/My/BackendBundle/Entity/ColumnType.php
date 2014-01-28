<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ColumnType
 *
 * @ORM\Table(name="column_type")
 * @ORM\Entity
 */
class ColumnType
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
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="My\CMSBundle\Entity\CMSComponentHasColumn", mappedBy="columnType")
     */
    protected $cmsComponentHasColumns;


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
     * @return ColumnType
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
     * Constructor
     */
    public function __construct()
    {
        $this->cmsComponentHasColumns = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cmsComponentHasColumns
     *
     * @param \My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns
     * @return ColumnType
     */
    public function addCmsComponentHasColumn(\My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns)
    {
        $this->cmsComponentHasColumns[] = $cmsComponentHasColumns;

        return $this;
    }

    /**
     * Remove cmsComponentHasColumns
     *
     * @param \My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns
     */
    public function removeCmsComponentHasColumn(\My\CMSBundle\Entity\CMSComponentHasColumn $cmsComponentHasColumns)
    {
        $this->cmsComponentHasColumns->removeElement($cmsComponentHasColumns);
    }

    /**
     * Get cmsComponentHasColumns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsComponentHasColumns()
    {
        return $this->cmsComponentHasColumns;
    }
}
