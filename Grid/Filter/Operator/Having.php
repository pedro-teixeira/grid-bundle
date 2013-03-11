<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator;

/**
 * Having
 */
class Having extends OperatorAbstract
{
    /**
     * @param array $value
     *
     * @throws \Exception
     */
    public function execute($value)
    {
        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder->having($this->getIndex() . " = :{$this->getIndexClean()}")
            ->setParameter($this->getIndexClean(), $value);
    }
}