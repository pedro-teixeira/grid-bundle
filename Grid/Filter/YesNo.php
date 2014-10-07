<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter;

/**
 * Filter YesNo
 */
class YesNo extends Select
{
    /**
     * @var array
     */
    protected $options = array(
        '0' => 'No',
        '1' => 'Yes'
    );
}
