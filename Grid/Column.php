<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid;

/**
 * Grid Column
 */
class Column
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $index;

    /**
     * @var string
     */
    protected $twig;

    /**
     * @var bool
     */
    protected $sortable = true;

    /**
     * @var string
     */
    protected $filterType = 'text';

    /**
     * @var \PedroTeixeira\Bundle\GridBundle\Grid\Filter\FilterAbstract
     */
    protected $filter;

    /**
     * @var string
     */
    protected $renderType = 'text';

    /**
     * @var \PedroTeixeira\Bundle\GridBundle\Grid\Render\RenderAbstract
     */
    protected $render;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     * @param string                                           $name
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container, $name = '')
    {
        $this->container = $container;
        $this->name = $name;
    }

    /**
     * @param string $name
     *
     * @return Column
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $field
     *
     * @return Column
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $index
     *
     * @return Column
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $twig
     *
     * @return Column
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * @return string
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @param bool $sortable
     *
     * @return Column
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * @param string $filterType
     *
     * @return Column
     */
    public function setFilterType($filterType)
    {
        $this->filterType = $filterType;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilterType()
    {
        return $this->filterType;
    }

    /**
     * Return filter
     *
     * @todo Merge all the reflections in one single method
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\Filter\FilterAbstract|bool
     *
     * @throws \Exception
     */
    public function getFilter()
    {
        if ($this->filter) {
            return $this->filter;
        }

        $filterType = $this->getFilterType();

        if (!$filterType) {
            return false;
        }

        $className = str_replace('_', ' ', $filterType);
        $className = ucwords(strtolower($className));
        $className = str_replace(' ', '', $className);

        try {
            $reflection = new \ReflectionClass('PedroTeixeira\Bundle\GridBundle\Grid\Filter\\' . $className);

            $this->filter = $reflection->newInstance(
                $this->container
            );

            $this->filter->setIndex($this->getIndex());

            return $this->filter;

        } catch (\Exception $e) {
            throw new \Exception(
                sprintf('Grid column type "%s" doesn\'t exist', $filterType)
            );
        }
    }

    /**
     * @return null|string
     */
    public function renderFilter()
    {
        if ($this->getFilter()) {
            return $this->getFilter()->render();
        }

        return null;
    }

    /**
     * @param string $renderType
     *
     * @return Column
     */
    public function setRenderType($renderType)
    {
        $this->renderType = $renderType;

        return $this;
    }

    /**
     * @return string
     */
    public function getRenderType()
    {
        return $this->renderType;
    }

    /**
     * Return render
     *
     * @todo Merge all the reflections in one single method
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\Render\RenderAbstract|bool
     *
     * @throws \Exception
     */
    public function getRender()
    {
        if ($this->render) {
            return $this->render;
        }

        $renderType = $this->getRenderType();

        if (!$renderType) {
            return false;
        }

        $className = str_replace('_', ' ', $renderType);
        $className = ucwords(strtolower($className));
        $className = str_replace(' ', '', $className);

        try {
            $reflection = new \ReflectionClass('PedroTeixeira\Bundle\GridBundle\Grid\Render\\' . $className);

            $this->render = $reflection->newInstance(
                $this->container
            );

            return $this->render;
        } catch (\Exception $e) {
            throw new \Exception(
                sprintf('Grid render type "%s" doesn\'t exist', $renderType)
            );
        }
    }
}