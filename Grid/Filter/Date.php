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
     * @var string
     */
    protected $dateFormat;

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        parent::__construct($container);

        $this->dateFormat = $this->container->getParameter('pedro_teixeira_grid.date.date_format');
        $this->setPlaceholder(strtoupper($this->dateFormat));
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->getUseDatePicker()) {
            $html  = '<input ' . $this->getNameAndId() . ' type="text" value="' . $this->getValue() .
                '" placeholder="' . $this->getPlaceholder() .
                '" data-date-format="' . strtolower($this->dateFormat) . '">';

            $html .= '<script type="text/javascript">' .
                '$(document).ready(function () {$("#' . $this->getId() . '").datepicker()})</script>';
        } else {
            $html = '<input ' . $this->getNameAndId() . ' type="date" value="' . $this->getValue() .
                '" placeholder="' . $this->getPlaceholder() . '">';
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
