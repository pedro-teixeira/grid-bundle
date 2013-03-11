<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter;

/**
 * Filter Text
 */
class Text extends FilterAbstract
{
    /**
     * @var string
     */
    protected $inputType = 'text';

    /**
     * @return string
     */
    public function render()
    {
        $html = '<input ' . $this->getNameAndId() . ' type="' . $this->getInputType() . '" value="' . $this->getValue() . '" placeholder="' . $this->getPlaceholder() . '">';

        return $html;
    }

    /**
     * @param string $inputType
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\Filter\Text
     */
    public function setInputType($inputType)
    {
        $this->inputType = $inputType;

        return $this;
    }

    /**
     * @return string
     */
    public function getInputType()
    {
        return $this->inputType;
    }
}