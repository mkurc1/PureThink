<?php

namespace My\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Series
 *
 * @ORM\Table(name="series")
 * @ORM\Entity(repositoryClass="My\BackendBundle\Repository\SeriesRepository")
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
     * @ORM\OneToMany(targetEntity="My\CMSBundle\Entity\CMSMenu", mappedBy="series")
     */
    protected $cmsMenus;

    /**
     * @ORM\OneToMany(targetEntity="My\FileBundle\Entity\File", mappedBy="series")
     */
    protected $files;

    /**
     * @ORM\OneToMany(targetEntity="My\CMSBundle\Entity\CMSComponent", mappedBy="series")
     */
    protected $cmsComponents;

    /**
     * @ORM\OneToMany(targetEntity="My\CMSBundle\Entity\CMSComponentOnPage", mappedBy="series")
     */
    protected $cmsComponentOnPages;


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
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add cmsMenus
     *
     * @param \My\CMSBundle\Entity\CMSMenu $cmsMenus
     * @return Series
     */
    public function addCmsMenu(\My\CMSBundle\Entity\CMSMenu $cmsMenus)
    {
        $this->cmsMenus[] = $cmsMenus;

        return $this;
    }

    /**
     * Remove cmsMenus
     *
     * @param \My\CMSBundle\Entity\CMSMenu $cmsMenus
     */
    public function removeCmsMenu(\My\CMSBundle\Entity\CMSMenu $cmsMenus)
    {
        $this->cmsMenus->removeElement($cmsMenus);
    }

    /**
     * Get cmsMenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsMenus()
    {
        return $this->cmsMenus;
    }

    /**
     * Add files
     *
     * @param \My\FileBundle\Entity\File $files
     * @return Series
     */
    public function addFile(\My\FileBundle\Entity\File $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files
     *
     * @param \My\FileBundle\Entity\File $files
     */
    public function removeFile(\My\FileBundle\Entity\File $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add cmsComponents
     *
     * @param \My\CMSBundle\Entity\CMSComponent $cmsComponents
     * @return Series
     */
    public function addCmsComponent(\My\CMSBundle\Entity\CMSComponent $cmsComponents)
    {
        $this->cmsComponents[] = $cmsComponents;

        return $this;
    }

    /**
     * Remove cmsComponents
     *
     * @param \My\CMSBundle\Entity\CMSComponent $cmsComponents
     */
    public function removeCmsComponent(\My\CMSBundle\Entity\CMSComponent $cmsComponents)
    {
        $this->cmsComponents->removeElement($cmsComponents);
    }

    /**
     * Get cmsComponents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsComponents()
    {
        return $this->cmsComponents;
    }

    /**
     * Add cmsComponentOnPages
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages
     * @return Series
     */
    public function addCmsComponentOnPage(\My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages)
    {
        $this->cmsComponentOnPages[] = $cmsComponentOnPages;

        return $this;
    }

    /**
     * Remove cmsComponentOnPages
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages
     */
    public function removeCmsComponentOnPage(\My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages)
    {
        $this->cmsComponentOnPages->removeElement($cmsComponentOnPages);
    }

    /**
     * Get cmsComponentOnPages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsComponentOnPages()
    {
        return $this->cmsComponentOnPages;
    }
}