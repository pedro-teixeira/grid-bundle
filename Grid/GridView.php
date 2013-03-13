<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid;

use PedroTeixeira\Bundle\GridBundle\Grid\GridAbstract;

/**
 * Grid View
 */
class GridView
{
    /**
     * @var GridAbstract
     */
    protected $grid;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @param GridAbstract                                     $grid
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(GridAbstract $grid, \Symfony\Component\DependencyInjection\Container $container)
    {
        $this->grid = $grid;
        $this->container = $container;
    }

    /**
     * @return GridAbstract
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @return int
     */
    public function getPaginationLimit()
    {
        return $this->container->getParameter('pedro_teixeira_grid.pagination.limit');
    }
}