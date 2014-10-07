<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator;

/**
 * Operator Abstract
 */
abstract class OperatorAbstract
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
    protected $indexClean;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var string
     */
    protected $where = 'AND';

    /**
     * @param string|array $value
     *
     * @return void
     */
    abstract public function execute($value);

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $index
     *
     * @return OperatorAbstract
     */
    public function setIndex($index)
    {
        $this->index = $index;

        $this->setIndexClean(
            str_replace('.', '', $index)
        );

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
     * @param string $indexClean
     *
     * @return OperatorAbstract
     */
    public function setIndexClean($indexClean)
    {
        $this->indexClean = $indexClean;

        return $this;
    }

    /**
     * @return string
     */
    public function getIndexClean()
    {
        return $this->indexClean;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     *
     * @return OperatorAbstract
     */
    public function setQueryBuilder(\Doctrine\ORM\QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param string $where
     *
     * @return OperatorAbstract
     */
    public function setWhere($where)
    {
        $this->where = $where;

        return $this;
    }

    /**
     * @return string
     */
    public function getWhere()
    {
        return $this->where;
    }
}
