<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="cms_menu")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\MenuRepository")
 */
class Menu
{
    const ARTICLE_LINK = 1;
    const STRING_LINK = 2;

    public static $linkTypes = [
        self::ARTICLE_LINK => 'Article',
        self::STRING_LINK => 'Url'
    ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotNull()
     * @Assert\Length(max="128")
     */
    private $name;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $published = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isNewPage = false;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $typeOfLink = self::ARTICLE_LINK;

    /**
     * @var string
     * @Assert\Url()
     * @ORM\Column(type="string", nullable=true)
     */
    private $url;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menus")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="menu")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $menus;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $language;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="MenuType")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $article;


    public function getActiveChildren()
    {
        $result = new ArrayCollection();
        $menus = $this->getMenus();
        /** @var Menu $menu */
        foreach ($menus as $menu) {
            if ($menu->getPublished() && $menu->getArticle() && $menu->getArticle()->getPublished()) {
                $result->add($menu);
            }
        }

        return $result;
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
     * Set name
     *
     * @param string $name
     * @return Menu
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
        $this->menus = new ArrayCollection();
    }

    /**
     * Set menu
     *
     * @param Menu $menu
     * @return Menu
     */
    public function setMenu(Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Add menus
     *
     * @param Menu $menus
     * @return Menu
     */
    public function addMenu(Menu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param Menu $menus
     */
    public function removeMenu(Menu $menus)
    {
        $this->menus->removeElement($menus);
    }

    /**
     * Get menus
     *
     * @return Collection
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getName();
    }

    /**
     * Set language
     *
     * @param Language $language
     * @return Menu
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set isNewPage
     *
     * @param boolean $isNewPage
     * @return Menu
     */
    public function setIsNewPage($isNewPage)
    {
        $this->isNewPage = $isNewPage;

        return $this;
    }

    /**
     * Get isNewPage
     *
     * @return boolean
     */
    public function getIsNewPage()
    {
        return $this->isNewPage;
    }

    /**
     * Set article
     *
     * @param Article $article
     * @return Menu
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set type
     *
     * @param MenuType $type
     * @return Menu
     */
    public function setType(MenuType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return MenuType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Menu
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @return int
     */
    public function getTypeOfLink()
    {
        return $this->typeOfLink;
    }

    /**
     * @param int $typeOfLink
     */
    public function setTypeOfLink($typeOfLink)
    {
        $this->typeOfLink = $typeOfLink;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
