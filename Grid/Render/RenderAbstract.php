<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Render;

/**
 * Render Abstract
 */
abstract class RenderAbstract
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $value;

    /**
     * @return string
     */
    abstract public function render();

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\Filter\RenderAbstract
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $value
     *
     * @return RenderAbstract
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}