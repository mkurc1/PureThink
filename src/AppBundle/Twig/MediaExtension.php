<?php

namespace AppBundle\Twig;

use Sonata\MediaBundle\Twig\Extension\MediaExtension as BaseMediaExtension;
use Symfony\Component\HttpKernel\KernelInterface;

class MediaExtension extends \Twig_Extension
{
    /**
     * @var BaseMediaExtension
     */
    private $twigExtension;

    /**
     * @var KernelInterface
     */
    private $kernel;

    public function __construct(KernelInterface $kernel, BaseMediaExtension $twigExtension)
    {
        $this->twigExtension = $twigExtension;
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('is_media_exist', [$this, 'isMediaExist'])
        ];
    }

    public function isMediaExist($media = null, $format)
    {
        $web = $this->kernel->getRootDir() . '/../web';
        $path = $this->twigExtension->path($media, $format);

        return file_exists($web . $path);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'media_extension';
    }
}