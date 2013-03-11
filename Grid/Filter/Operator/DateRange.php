<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator;

/**
 * DateRange
 */
class DateRange extends OperatorAbstract
{
    /**
     * @param array $value
     *
     * @throws \Exception
     */
    public function execute($value)
    {
        if (!is_array($value) || count($value) != 2) {
            throw new \Exception('Value for date range comparison should have to values');
        }

        $queryBuilder = $this->getQueryBuilder();

        if (!empty($value[0])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->gte(
                    $this->getIndex(),
                    ":{$this->getIndexClean()}_1"
                ))
                ->setParameter(
                    ":{$this->getIndexClean()}_1",
                    $value[0] . ' 00:00:00'
                );
        }

        if (!empty($value[1])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->lte(
                    $this->getIndex(),
                    ":{$this->getIndexClean()}_2"
                ))
                ->setParameter(
                    ":{$this->getIndexClean()}_2",
                    $value[1] . ' 23:59:59'
                );
        }
    }
}