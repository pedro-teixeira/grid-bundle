<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Render;

/**
 * Render Text
 */
class Text extends RenderAbstract
{
    /**
     * @return string
     */
    public function render()
    {
        return (string) $this->getValue();
    }
}
