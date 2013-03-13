<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter;

/**
 * Filter DateRange
 */
class DateRange extends Date
{
    /**
     * @var string
     */
    protected $operatorType = 'date_range';

    /**
     * @var string
     */
    protected $inputSeparator = ' : ';

    /**
     * @return string
     */
    public function render()
    {
        if ($this->getUseDatePicker()) {

            $html  = '<input class="date-input" name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'from" type="text" value="' . $this->getValue() . '" placeholder="' . $this->getPlaceholder() . '" data-date-format="' . strtolower($this->container->getParameter('pedro_teixeira_grid.date.date_format')) . '">';
            $html .= $this->getInputSeparator();
            $html .= '<input class="date-input" name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'to" type="text" value="' . $this->getValue() . '" placeholder="' . $this->getPlaceholder() . '" data-date-format="' . strtolower($this->container->getParameter('pedro_teixeira_grid.date.date_format')) . '">';
            $html .= '<script type="text/javascript">$(document).ready(function () {$("#' . $this->getId() . 'from").datepicker(); $("#' . $this->getId() . 'to").datepicker()})</script>';

        } else {

            $html  = '<input name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'from" type="date" value="' . $this->getValue() . '"> ';
            $html .= '<input name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'to" type="date" value="' . $this->getValue() . '">';

        }

        return $html;
    }

    /**
     * @param string $inputSeparator
     *
     * @return DateRange
     */
    public function setInputSeparator($inputSeparator)
    {
        $this->inputSeparator = $inputSeparator;

        return $this;
    }

    /**
     * @return string
     */
    public function getInputSeparator()
    {
        return $this->inputSeparator;
    }
}