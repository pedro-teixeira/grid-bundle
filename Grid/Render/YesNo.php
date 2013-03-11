<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Render;

/**
 * Render YesNo
 */
class YesNo extends RenderAbstract
{
    /**
     * @return string
     */
    public function render()
    {
        if ($this->getValue()) {
            return '<i class="icon-ok"></i>';
        } else {
            return '<i class="icon-remove"></i>';
        }
    }
}