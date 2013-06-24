<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Render;

use Symfony\Component\Locale\Stub\StubNumberFormatter;

/**
 * Render Currency
 */
class Currency extends RenderAbstract
{
    /**
     * @return string
     */
    public function render()
    {
        $formatter = new StubNumberFormatter($this->container->getParameter('pedro_teixeira_grid.currency.locale'), StubNumberFormatter::CURRENCY);
        return $formatter->formatCurrency($this->getValue(), $this->container->getParameter('pedro_teixeira_grid.currency.currency'));
    }
}

