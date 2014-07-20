<?php

namespace Purethink\CoreBundle\Twig;

use RaulFraile\Bundle\LadybugBundle\Twig\Extension\LadybugExtension as CoreExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Twig extension for the bundle.
 */
class LadybugExtension extends CoreExtension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Getter.
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            'ladybug_dump' => new \Twig_Filter_Method($this, 'ladybug_dump', ['is_safe' => ['html']]),
            'ld'           => new \Twig_Filter_Method($this, 'ladybug_dump', ['is_safe' => ['html']]),
            'ldl'          => new \Twig_Filter_Method($this, 'ladybug_log', ['is_safe' => ['html']])
        ];
    }

    /**
     * Getter.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            'ladybug_dump' => new \Twig_Function_Method($this, 'ladybug_dump', ['is_safe' => ['html']]),
            'ld'           => new \Twig_Function_Method($this, 'ladybug_dump', ['is_safe' => ['html']]),
            'ldl'          => new \Twig_Function_Method($this, 'ladybug_log', ['is_safe' => ['html']])
        ];
    }

    /**
     * Returns $arg or array of $args, depending on number of arguments
     *
     * @return array|mixed
     */
    public function ladybug_log()
    {
        $ladybug = $this->getContainer()->get('ladybug');
        $html = call_user_func_array(array($ladybug, 'log'), func_get_args());

        return func_num_args() == 1 ? func_get_arg(0) : func_get_args();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ladybug_extension';
    }
}
