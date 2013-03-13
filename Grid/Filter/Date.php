<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter;

/**
 * Filter Date
 */
class Date extends FilterAbstract
{
    /**
     * @var string
     */
    protected $operatorType = 'date';

    /**
     * @return string
     */
    public function render()
    {
        if ($this->getUseDatePicker()) {
            $html  = '<input ' . $this->getNameAndId() . ' type="text" value="' . $this->getValue() . '" placeholder="' . $this->getPlaceholder() . '" data-date-format="' . strtolower($this->container->getParameter('pedro_teixeira_grid.date.date_format')) . '">';
            $html .= '<script type="text/javascript">$(document).ready(function () {$("#' . $this->getId() . '").datepicker()})</script>';
        } else {
            $html = '<input ' . $this->getNameAndId() . ' type="date" value="' . $this->getValue() . '" placeholder="' . $this->getPlaceholder() . '">';
        }

        return $html;
    }

    /**
     * @return boolean
     */
    public function getUseDatePicker()
    {
        return $this->container->getParameter('pedro_teixeira_grid.date.use_datepicker');
    }
}