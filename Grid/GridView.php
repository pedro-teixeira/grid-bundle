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
     * Constructor
     *
     * @param GridAbstract $grid
     */
    public function __construct(GridAbstract $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return GridAbstract
     */
    public function getGrid()
    {
        return $this->grid;
    }
}