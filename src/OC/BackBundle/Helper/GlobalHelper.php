<?php


namespace OC\BackBundle\Helper;


use Symfony\Component\DependencyInjection\Container;

class GlobalHelper
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }


}