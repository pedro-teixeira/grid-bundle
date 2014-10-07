<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator;

/**
 * NumberRange
 */
class NumberRange extends OperatorAbstract
{
    /**
     * @param array $value
     *
     * @throws \Exception
     */
    public function execute($value)
    {
        if (!is_array($value) || count($value) != 2) {
            throw new \Exception('Value for number range comparison should have to values');
        }

        $queryBuilder = $this->getQueryBuilder();

        if (!empty($value[0])) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->gte(
                    $this->getIndex(),
                    ":{$this->getIndexClean()}_1"
                )
            )
                ->setParameter(
                    ":{$this->getIndexClean()}_1",
                    (float) $value[0]
                );
        }

        if (!empty($value[1])) {

            $queryBuilder->andWhere(
                $queryBuilder->expr()->lte(
                    $this->getIndex(),
                    ":{$this->getIndexClean()}_2"
                )
            )
                ->setParameter(
                    ":{$this->getIndexClean()}_2",
                    (float) $value[1]
                );
        }
    }
}
