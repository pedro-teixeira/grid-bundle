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
    protected $fromLabel = 'From';

    /**
     * @var string
     */
    protected $toLabel = 'To';

    /**
     * @return string
     */
    public function render()
    {
        $html  = '<p>' . $this->getFromLabel() . ': <input name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'from" type="' . $this->getInputType() . '" value="' . $this->getValue() . '"></p>';
        $html .= '<p>' . $this->getToLabel() . ': <input name="' . $this->getIndex() . '[]" id="' . $this->getId() . 'to" type="' . $this->getInputType() . '" value="' . $this->getValue() . '"></p>';

        return $html;
    }

    /**
     * @param string $fromLabel
     *
     * @return DateRange
     */
    public function setFromLabel($fromLabel)
    {
        $this->fromLabel = $fromLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromLabel()
    {
        return $this->translate($this->fromLabel);
    }

    /**
     * @param string $toLabel
     *
     * @return DateRange
     */
    public function setToLabel($toLabel)
    {
        $this->toLabel = $toLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getToLabel()
    {
        return $this->translate($this->toLabel);
    }
}