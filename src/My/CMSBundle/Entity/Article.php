<?php

namespace My\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use My\BackendBundle\Entity\Metadata;
use My\BackendBundle\Entity\MetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use My\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="cms_article")
 * @ORM\Entity(repositoryClass="My\CMSBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class Article implements MetadataInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPublic = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Expose
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $views = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Serializer\Expose
     * @Assert\NotNull()
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="My\UserBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="My\BackendBundle\Entity\Series")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Serializer\Expose
     * @Assert\NotNull()
     */
    private $series;

    /**
     * @ORM\OneToOne(targetEntity="My\BackendBundle\Entity\Metadata", cascade={"persist"})
     */
    private $metadata;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasArticle", mappedBy="article")
     */
    private $componentHasArticle;


    public function incrementArticleViews()
    {
        $this->setViews($this->getViews() + 1);
    }

    public function getSEOData()
    {
        return $this->getMetadata();
    }

    /**
     * @ORM\PreRemove
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        foreach ($this->getComponentHasArticle() as $component) {
            $element = $component->getComponentHasElement();

            $om = $args->getObjectManager();
            $om->remove($element);
            $om->flush();
        }
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
     * @return Article
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
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Article
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
     * Set content
     *
     * @param string $content
     * @return Article
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
     * Set slug
     *
     * @param string $slug
     * @return Article
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Article
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
     * @return Article
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
     * Set language
     *
     * @param \My\CMSBundle\Entity\Language $language
     * @return Article
     */
    public function setLanguage(\My\CMSBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \My\CMSBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
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
     * Set user
     *
     * @param \My\UserBundle\Entity\User $user
     * @return Article
     */
    public function setUser(\My\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \My\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set series
     *
     * @param \My\BackendBundle\Entity\Series $series
     * @return Article
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
    public function __construct(User $user = null)
    {
        $this->componentHasArticle = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setMetadata(new Metadata());

        if (null != $user) {
            $this->setUser($user);
        }
    }

    /**
     * Set metadata
     *
     * @param \My\BackendBundle\Entity\Metadata $metadata
     * @return Article
     */
    public function setMetadata(\My\BackendBundle\Entity\Metadata $metadata = null)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return \My\BackendBundle\Entity\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Article
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Add componentHasArticle
     *
     * @param \My\CMSBundle\Entity\ComponentHasArticle $componentHasArticle
     * @return Article
     */
    public function addComponentHasArticle(\My\CMSBundle\Entity\ComponentHasArticle $componentHasArticle)
    {
        $this->componentHasArticle[] = $componentHasArticle;

        return $this;
    }

    /**
     * Remove componentHasArticle
     *
     * @param \My\CMSBundle\Entity\ComponentHasArticle $componentHasArticle
     */
    public function removeComponentHasArticle(\My\CMSBundle\Entity\ComponentHasArticle $componentHasArticle)
    {
        $this->componentHasArticle->removeElement($componentHasArticle);
    }

    /**
     * Get componentHasArticle
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponentHasArticle()
    {
        return $this->componentHasArticle;
    }
}
