<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMSLanguage
 *
 * @ORM\Table(name="cms_language")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\CMSLanguageRepository")
 */
class CMSLanguage
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
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=3)
     */
    private $alias;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean")
     */
    private $isPublic;

    /**
     * @ORM\OneToMany(targetEntity="CMSArticle", mappedBy="language")
     */
    protected $articles;

    /**
     * @ORM\OneToMany(targetEntity="CMSMenu", mappedBy="language")
     */
    protected $menus;

    /**
     * @ORM\OneToMany(targetEntity="CMSComponentOnPage", mappedBy="language")
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
     * @return CMSLanguage
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
     * Set alias
     *
     * @param string $alias
     * @return CMSLanguage
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return CMSLanguage
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add articles
     *
     * @param \My\CMSBundle\Entity\CMSArticle $articles
     * @return CMSLanguage
     */
    public function addArticle(\My\CMSBundle\Entity\CMSArticle $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \My\CMSBundle\Entity\CMSArticle $articles
     */
    public function removeArticle(\My\CMSBundle\Entity\CMSArticle $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
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
     * Add menus
     *
     * @param \My\CMSBundle\Entity\CMSMenu $menus
     * @return CMSLanguage
     */
    public function addMenu(\My\CMSBundle\Entity\CMSMenu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \My\CMSBundle\Entity\CMSMenu $menus
     */
    public function removeMenu(\My\CMSBundle\Entity\CMSMenu $menus)
    {
        $this->menus->removeElement($menus);
    }

    /**
     * Get menus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Add cmsComponentOnPages
     *
     * @param \My\CMSBundle\Entity\CMSComponentOnPage $cmsComponentOnPages
     * @return CMSLanguage
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
