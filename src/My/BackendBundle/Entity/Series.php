<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Series
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Series
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
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="series")
     */
    protected $menu;

    /**
     * @ORM\OneToMany(targetEntity="My\CMSBundle\Entity\CMSArticle", mappedBy="series")
     */
    protected $cmsArticles;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="series")
     */
    protected $module;


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
     * @return Series
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
     * Set menu
     *
     * @param \My\BackendBundle\Entity\Menu $menu
     * @return Series
     */
    public function setMenu(\My\BackendBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \My\BackendBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cmsArticles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cmsArticles
     *
     * @param \My\CMSBundle\Entity\CMSArticle $cmsArticles
     * @return Series
     */
    public function addCmsArticle(\My\CMSBundle\Entity\CMSArticle $cmsArticles)
    {
        $this->cmsArticles[] = $cmsArticles;

        return $this;
    }

    /**
     * Remove cmsArticles
     *
     * @param \My\CMSBundle\Entity\CMSArticle $cmsArticles
     */
    public function removeCmsArticle(\My\CMSBundle\Entity\CMSArticle $cmsArticles)
    {
        $this->cmsArticles->removeElement($cmsArticles);
    }

    /**
     * Get cmsArticles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsArticles()
    {
        return $this->cmsArticles;
    }

    /**
     * Set module
     *
     * @param \My\BackendBundle\Entity\Module $module
     * @return Series
     */
    public function setModule(\My\BackendBundle\Entity\Module $module = null)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return \My\BackendBundle\Entity\Module 
     */
    public function getModule()
    {
        return $this->module;
    }
}