<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Render;

/**
 * Render Date
 */
class Date extends RenderAbstract
{
    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * @return string
     */
    public function render()
    {
        if ($this->getValue() instanceof \DateTime) {
            return $this->getValue()->format($this->getDateFormat());
        }
    }

    /**
     * @param string $dateFormat
     *
     * @return Date
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }
}