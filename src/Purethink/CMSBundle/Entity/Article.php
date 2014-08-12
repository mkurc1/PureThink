<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="cms_article")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Article implements MetadataInterface, ArticleViewInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $published = false;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotNull()
     */
    private $excerpt;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="Metadata", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $metadata;

    /**
     * @ORM\OneToOne(targetEntity="ArticleView", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $view;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasArticle", mappedBy="article")
     */
    private $componentHasArticle;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     * @ORM\JoinTable(name="cms_article_has_tag")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $category;


    public function getViews()
    {
        return $this->getView();
    }

    public function getSEOData()
    {
        return $this->getMetadata();
    }

    /**
     * @ORM\PreRemove
     *
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        /** @var ComponentHasArticle $component */
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
     * Set excerpt
     *
     * @param string $excerpt
     * @return Article
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
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
     * Set language
     *
     * @param Language $language
     * @return Article
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
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getName();
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Article
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Constructor
     *
     * @param User $user
     */
    public function __construct(User $user = null)
    {
        $this->componentHasArticle = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->setMetadata(new Metadata());
        $this->setView(new ArticleView());

        if (null != $user) {
            $this->setUser($user);
        }
    }

    /**
     * Add componentHasArticle
     *
     * @param ComponentHasArticle $componentHasArticle
     * @return Article
     */
    public function addComponentHasArticle(ComponentHasArticle $componentHasArticle)
    {
        $this->componentHasArticle[] = $componentHasArticle;

        return $this;
    }

    /**
     * Remove componentHasArticle
     *
     * @param ComponentHasArticle $componentHasArticle
     */
    public function removeComponentHasArticle(ComponentHasArticle $componentHasArticle)
    {
        $this->componentHasArticle->removeElement($componentHasArticle);
    }

    /**
     * Get componentHasArticle
     *
     * @return Collection
     */
    public function getComponentHasArticle()
    {
        return $this->componentHasArticle;
    }

    /**
     * Set metadata
     *
     * @param Metadata $metadata
     * @return Article
     */
    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Add tags
     *
     * @param Tag $tags
     * @return Article
     */
    public function addTag(Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param Tag $tags
     */
    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Article
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Article
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Article
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
     * Set view
     *
     * @param ArticleView $view
     * @return Article
     */
    public function setView(ArticleView $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return ArticleView
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return Article
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
