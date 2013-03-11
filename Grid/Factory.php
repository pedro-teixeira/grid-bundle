<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid;

/**
 * Grid Factory
 */
class Factory
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param string $gridClassName The name of the Grid descendant class that will be instantiated
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\GridAbstract
     */
    public function createGrid($gridClassName)
    {
        $gridClass = new \ReflectionClass($gridClassName);

        /* @var \PedroTeixeira\Bundle\GridBundle\Grid\GridAbstract $grid */
        $grid = $gridClass->newInstance($this->container);
        $grid->setupGrid();

        return $grid;
    }
}