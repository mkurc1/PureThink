<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;

class SiteExtension extends \Twig_Extension
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('tracking_code', [$this, 'getTrackingCode'])
        ];
    }

    public function getTrackingCode()
    {
        /** @var Site $site */
        $site = $this->getSiteRepository()->getSite();
        if ($site) {
            return $site->getTrackingCode();
        }

        return '';
    }

    private function getSiteRepository()
    {
        return $this->em->getRepository('AppBundle:Site');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'site_extension';
    }
}