<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Purethink\AdminBundle\Entity\Metadata;
use Purethink\AdminBundle\Entity\MetadataInterface;

/**
 * @ORM\Table(name="cms_website")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\WebSiteRepository")
 */
class WebSite implements MetadataInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Language")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $language;

    /**
     * @ORM\OneToOne(targetEntity="Purethink\AdminBundle\Entity\Metadata", cascade={"persist"})
     */
    private $metadata;


    public function __construct()
    {
        $this->setMetadata(new Metadata());
    }

    public function getSEOData()
    {
        return $this->getMetadata();
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
     * Set language
     *
     * @param \Purethink\CMSBundle\Entity\Language $language
     * @return WebSite
     */
    public function setLanguage(\Purethink\CMSBundle\Entity\Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Purethink\CMSBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set metadata
     *
     * @param \Purethink\AdminBundle\Entity\Metadata $metadata
     * @return WebSite
     */
    public function setMetadata(\Purethink\AdminBundle\Entity\Metadata $metadata = null)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return \Purethink\AdminBundle\Entity\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
