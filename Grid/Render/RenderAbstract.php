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
     * @var bool
     */
    protected $stringOnly = false;

    /**
     * @return string
     */
    abstract public function render();

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\Render\RenderAbstract
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

    /**
     * @param boolean $stringOnly
     *
     * @return RenderAbstract
     */
    public function setStringOnly($stringOnly)
    {
        $this->stringOnly = $stringOnly;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getStringOnly()
    {
        return $this->stringOnly;
    }
}