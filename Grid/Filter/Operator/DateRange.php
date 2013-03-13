<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator;

use Symfony\Component\Locale\Stub\DateFormat\FullTransformer;

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

            $transformer = new FullTransformer(
                $this->container->getParameter('pedro_teixeira_grid.date.date_format'),
                $this->container->getParameter('locale')
            );
            $date = new \DateTime();
            $transformer->parse($date, $value[0]);

            $queryBuilder->andWhere(
                $queryBuilder->expr()->gte(
                    $this->getIndex(),
                    ":{$this->getIndexClean()}_1"
                ))
                ->setParameter(
                    ":{$this->getIndexClean()}_1",
                    $date->format('Y-m-d') . ' 00:00:00'
                );
        }

        if (!empty($value[1])) {

            $transformer = new FullTransformer(
                $this->container->getParameter('pedro_teixeira_grid.date.date_format'),
                $this->container->getParameter('locale')
            );
            $date = new \DateTime();
            $transformer->parse($date, $value[1]);

            $queryBuilder->andWhere(
                $queryBuilder->expr()->lte(
                    $this->getIndex(),
                    ":{$this->getIndexClean()}_2"
                ))
                ->setParameter(
                    ":{$this->getIndexClean()}_2",
                    $date->format('Y-m-d') . ' 23:59:59'
                );
        }
    }
}