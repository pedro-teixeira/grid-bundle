<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter;

/**
 * Filter Abstract
 */
abstract class FilterAbstract
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $index;

    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $placeholder = null;

    /**
     * @var string|array
     */
    protected $value = null;

    /**
     * @var string
     */
    protected $operatorType = 'comparison';

    /**
     * @var \PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator\OperatorAbstract
     */
    protected $operator;

    /**
     * @return string
     */
    abstract public function render();

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    protected function translate($string)
    {
        return $this->container->get('translator')->trans($string);
    }

    /**
     * @return string
     */
    protected function getNameAndId()
    {
        return 'name="' . $this->getIndex() . '" id="' . $this->getId() . '"';
    }

    /**
     * @param string $index
     *
     * @return FilterAbstract
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
     * @param string $id
     *
     * @return FilterAbstract
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (is_null($this->id) ? uniqid() : $this->id);
    }

    /**
     * @param string $placeholder
     *
     * @return FilterAbstract
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $value
     *
     * @return FilterAbstract
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return array|null|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $operatorType
     *
     * @return FilterAbstract
     */
    public function setOperatorType($operatorType)
    {
        $this->operatorType = $operatorType;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperatorType()
    {
        return $this->operatorType;
    }

    /**
     * Return operator
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator\OperatorAbstract|bool
     *
     * @throws \Exception
     */
    public function getOperator()
    {
        if ($this->operator) {
            return $this->operator;
        }

        $operatorType = $this->getOperatorType();

        if (!$operatorType) {
            return false;
        }

        $className = str_replace('_', ' ', $operatorType);
        $className = ucwords(strtolower($className));
        $className = str_replace(' ', '', $className);

        try {
            $reflection = new \ReflectionClass('PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator\\' . $className);

            $this->operator = $reflection->newInstance(
                $this->container
            );

            $this->operator->setIndex($this->getIndex());

            return $this->operator;
        } catch (\Exception $e) {
            throw new \Exception(
                sprintf('Filter operator type "%s" doesn\'t exist', $operatorType)
            );
        }
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param array|string               $value
     */
    public function execute(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        $this->getOperator()
            ->setQueryBuilder($queryBuilder)
            ->execute($value);
    }
}