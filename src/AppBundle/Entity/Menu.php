<?php

namespace AppBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="cms_menu",
 *   indexes={
 *     @ORM\Index(columns={"dtype"})
 *   })
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MenuRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
abstract class Menu implements SoftDeleteable
{
    CONST TYPE_OF_ARTICLE = 'Article';
    CONST TYPE_OF_URL = 'Url';

    use Translatable;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $published = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isNewPage = false;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menus")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    protected $menu;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="menu")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $menus;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="MenuType")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    protected $type;

    protected $translations;

    abstract public function getTypeOf();

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getCurrentTranslation()->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
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
     * @return string
     */
    public function __toString()
    {
        if ($this->translations && $this->translations->count()) {
            return (string)$this->getName();
        }
        return '';
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
}
