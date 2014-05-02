<?php

namespace Purethink\FileBundle\Entity;

use Purethink\CoreBundle\Entity\File as BaseFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class File extends BaseFile
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Purethink\CMSBundle\Entity\ComponentHasFile", mappedBy="file")
     */
    private $componentHasFile;

    /**
     * @ORM\PreRemove
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        foreach ($this->getComponentHasFile() as $component) {
            $element = $component->getComponentHasElement();

            $om = $args->getObjectManager();
            $om->remove($element);
            $om->flush();
        }
    }

    public function __construct(User $user = null)
    {
        $this->componentHasFile = new \Doctrine\Common\Collections\ArrayCollection();
        if (null != $user) {
            $this->setUser($user);
        }
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
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
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return File
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    protected function getUploadDir()
    {
        return 'uploads';
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
     * Add componentHasFile
     *
     * @param \Purethink\CMSBundle\Entity\ComponentHasFile $componentHasFile
     * @return File
     */
    public function addComponentHasFile(\Purethink\CMSBundle\Entity\ComponentHasFile $componentHasFile)
    {
        $this->componentHasFile[] = $componentHasFile;

        return $this;
    }

    /**
     * Remove componentHasFile
     *
     * @param \Purethink\CMSBundle\Entity\ComponentHasFile $componentHasFile
     */
    public function removeComponentHasFile(\Purethink\CMSBundle\Entity\ComponentHasFile $componentHasFile)
    {
        $this->componentHasFile->removeElement($componentHasFile);
    }

    /**
     * Get componentHasFile
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponentHasFile()
    {
        return $this->componentHasFile;
    }
}
