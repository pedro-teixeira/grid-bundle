<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Render;

use Symfony\Component\Locale\Stub\DateFormat\FullTransformer;

/**
 * Render Date
 */
class DateTime extends RenderAbstract
{
    /**
     * @return string
     */
    public function render()
    {
        if ($this->getValue() instanceof \DateTime) {

            $transformer = new FullTransformer(
                $this->container->getParameter('pedro_teixeira_grid.date.date_time_format'),
                $this->container->getParameter('locale')
            );

            return $transformer->format($this->getValue());
        }
    }
}
