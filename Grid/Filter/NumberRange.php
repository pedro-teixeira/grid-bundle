<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter;

/**
 * Filter NumberRange
 */
class NumberRange extends FilterAbstract
{
    /**
     * @var string
     */
    protected $operatorType = 'number_range';

    /**
     * @var string
     */
    protected $inputSeparator = ' : ';

    /**
     * @return string
     */
    public function render()
    {
        $html  = '<input class="number-input" name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'from" type="text" placeholder="' . $this->getPlaceholder() . '" value="' . $this->getValue() . '"> ';
        $html .= $this->getInputSeparator();
        $html .= '<input class="number-input" name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'to" type="text" placeholder="' . $this->getPlaceholder() . '" value="' . $this->getValue() . '">';

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