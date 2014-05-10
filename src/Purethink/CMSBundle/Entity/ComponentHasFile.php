<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class ComponentHasFile extends ComponentHasValue
{
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $file;


    public function setContent($content)
    {
        $this->setFile($content);

        return $this;
    }

    public function getContent()
    {
        return $this->getFile();
    }

    public function getStringContent()
    {
        if ($this->getContent()) {
            return $this->getContent();
        } else {
            return '';
        }
    }

    /**
     * Set file
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $file
     * @return ComponentHasFile
     */
    public function setFile(\Application\Sonata\MediaBundle\Entity\Media $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getFile()
    {
        return $this->file;
    }
}
