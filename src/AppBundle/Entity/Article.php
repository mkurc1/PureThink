<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="cms_article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Article implements MetadataInterface, ArticleViewInterface, SoftDeleteable
{
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $published = false;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $excerpt;

    /**
     * @var Language
     *
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    private $language;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $user;

    /**
     * @var Metadata
     *
     * @ORM\OneToOne(targetEntity="Metadata", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $metadata;

    /**
     * @var ArticleViewInterface
     *
     * @ORM\OneToOne(targetEntity="ArticleView", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $view;

    /**
     * @ORM\OneToMany(targetEntity="ComponentHasArticle", mappedBy="article")
     */
    private $componentHasArticle;


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

            $em = $args->getEntityManager();
            $em->remove($element);
            $em->flush();
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
     * @param UserInterface $user
     * @return Article
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Constructor
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user = null)
    {
        $this->componentHasArticle = new ArrayCollection();
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
     * @param ArticleViewInterface $view
     * @return Article
     */
    public function setView(ArticleViewInterface $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return ArticleViewInterface
     */
    public function getView()
    {
        return $this->view;
    }
}
