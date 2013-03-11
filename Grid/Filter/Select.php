<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter;

/**
 * Filter Select
 */
class Select extends FilterAbstract
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var bool
     */
    protected $emptyChoice = true;

    /**
     * @var string
     */
    protected $emptyChoiceLabel = '--';

    /**
     * @return string
     */
    public function render()
    {
        $html = '<select ' . $this->getNameAndId() . '>';

        if ($this->getEmptyChoice()) {
            $html .= '<option value="" selected>' . $this->translate($this->getEmptyChoiceLabel()) . '</option>';
        }

        if (is_array($this->getOptions())) {
            foreach ($this->getOptions() as $key => $value) {
                $html .= '<option value="' . $key . '">' . $this->translate($value) . '</option>';
            }
        }

        $html .= '</select>';

        return $html;
    }

    /**
     * @param bool $emptyChoice
     *
     * @return Select
     */
    public function setEmptyChoice($emptyChoice)
    {
        $this->emptyChoice = $emptyChoice;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getEmptyChoice()
    {
        return $this->emptyChoice;
    }

    /**
     * @param string $emptyChoiceLabel
     *
     * @return Select
     */
    public function setEmptyChoiceLabel($emptyChoiceLabel)
    {
        $this->emptyChoiceLabel = $emptyChoiceLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmptyChoiceLabel()
    {
        return $this->emptyChoiceLabel;
    }

    /**
     * @param array $options
     *
     * @return Select
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}