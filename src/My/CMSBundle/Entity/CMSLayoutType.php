<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSLayoutType
 *
 * @ORM\Table(name="cms_layout_type")
 * @ORM\Entity
 */
class CMSLayoutType
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
     * @ORM\OneToMany(targetEntity="CMSLayout", mappedBy="cmsLayoutType")
     */
    protected $cmsLayouts;


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
     * @return CMSLayoutType
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
     * Constructor
     */
    public function __construct()
    {
        $this->cmsLayouts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cmsLayouts
     *
     * @param \My\CMSBundle\Entity\CMSLayout $cmsLayouts
     * @return CMSLayoutType
     */
    public function addCmsLayout(\My\CMSBundle\Entity\CMSLayout $cmsLayouts)
    {
        $this->cmsLayouts[] = $cmsLayouts;

        return $this;
    }

    /**
     * Remove cmsLayouts
     *
     * @param \My\CMSBundle\Entity\CMSLayout $cmsLayouts
     */
    public function removeCmsLayout(\My\CMSBundle\Entity\CMSLayout $cmsLayouts)
    {
        $this->cmsLayouts->removeElement($cmsLayouts);
    }

    /**
     * Get cmsLayouts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsLayouts()
    {
        return $this->cmsLayouts;
    }
}