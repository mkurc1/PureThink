<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use My\CoreBundle\Utility\RemoveDirectory;

/**
 * @ORM\Table(name="cms_template")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\TemplateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Template
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $author;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isEnable = false;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\Series")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $series;

    /**
     * @ORM\OneToMany(targetEntity="Script", mappedBy="template", cascade={"persist"}, orphanRemoval=true)
     */
    private $scripts;

    /**
     * @ORM\OneToMany(targetEntity="Style", mappedBy="template", cascade={"persist"}, orphanRemoval=true)
     */
    private $styles;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="template", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;


    /**
     * @ORM\PostPersist()
     */
    public function createDir()
    {
        $dir = $this->getUploadRootDir().'/'.$this->getSlug();

        if (is_dir($dir)) {
            return;
        }

        $userMask = umask(0);
        mkdir($dir, 0777);
        mkdir($dir.'/'.$this->getStylesUploadDir(), 0777);
        mkdir($dir.'/'.$this->getScriptsUploadDir(), 0777);
        mkdir($dir.'/'.$this->getImagesUploadDir(), 0777);
        umask($userMask);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeDir()
    {
        $dir = $this->getUploadRootDir().'/'.$this->getSlug();
        RemoveDirectory::rmdir($dir);
    }


    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'template';
    }

    public function getStylesUploadDir()
    {
        return 'css';
    }

    public function getScriptsUploadDir()
    {
        return 'js';
    }

    public function getImagesUploadDir()
    {
        return 'images';
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
     * @return Template
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
     * Set author
     *
     * @param string $author
     * @return Template
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set isEnable
     *
     * @param boolean $isEnable
     * @return Template
     */
    public function setIsEnable($isEnable)
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    /**
     * Get isEnable
     *
     * @return boolean
     */
    public function getIsEnable()
    {
        return $this->isEnable;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Template
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
     * @return Template
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
     * Set slug
     *
     * @param string $slug
     * @return Template
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return Template
     */
    public function setSeries(\My\BackendBundle\Entity\Series $series = null)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return \My\BackendBundle\Entity\Series 
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scripts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->styles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add scripts
     *
     * @param \My\CMSBundle\Entity\Script $scripts
     * @return Template
     */
    public function addScript(\My\CMSBundle\Entity\Script $scripts)
    {
        $scripts->setTemplate($this);

        $this->scripts[] = $scripts;

        return $this;
    }

    /**
     * Remove scripts
     *
     * @param \My\CMSBundle\Entity\Script $scripts
     */
    public function removeScript(\My\CMSBundle\Entity\Script $scripts)
    {
        $scripts->removeUpload();

        $this->scripts->removeElement($scripts);
    }

    /**
     * Get scripts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * Add styles
     *
     * @param \My\CMSBundle\Entity\Style $styles
     * @return Template
     */
    public function addStyle(\My\CMSBundle\Entity\Style $styles)
    {
        $styles->setTemplate($this);

        $this->styles[] = $styles;

        return $this;
    }

    /**
     * Remove styles
     *
     * @param \My\CMSBundle\Entity\Style $styles
     */
    public function removeStyle(\My\CMSBundle\Entity\Style $styles)
    {
        $styles->removeUpload();

        $this->styles->removeElement($styles);
    }

    /**
     * Get styles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Add images
     *
     * @param \My\CMSBundle\Entity\Image $images
     * @return Template
     */
    public function addImage(\My\CMSBundle\Entity\Image $images)
    {
        $images->setTemplate($this);

        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \My\CMSBundle\Entity\Image $images
     */
    public function removeImage(\My\CMSBundle\Entity\Image $images)
    {
        $images->removeUpload();

        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
