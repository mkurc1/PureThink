<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class ComponentHasFile extends ComponentHasValue
{
    /**
     * @ORM\ManyToOne(targetEntity="Media", cascade={"persist"}, fetch="EAGER")
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
     * @param Media $file
     * @return ComponentHasFile
     */
    public function setFile(Media $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return Media
     */
    public function getFile()
    {
        return $this->file;
    }
}
