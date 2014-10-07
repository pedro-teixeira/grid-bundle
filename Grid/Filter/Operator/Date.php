<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator;

use Symfony\Component\Locale\Stub\DateFormat\FullTransformer;

/**
 * Date
 */
class Date extends OperatorAbstract
{
    /**
     * @param string|array $value
     */
    public function execute($value)
    {
        $transformer = new FullTransformer(
            $this->container->getParameter('pedro_teixeira_grid.date.date_format'),
            $this->container->getParameter('locale')
        );
        $date = new \DateTime();
        $transformer->parse($date, $value);

        $queryBuilder = $this->getQueryBuilder();

        $where = $this->getQueryBuilder()->expr()->like($this->getIndex(), ":{$this->getIndexClean()}");

        if ($this->getWhere() == 'OR') {
            $queryBuilder->orWhere($where);
        } else {
            $queryBuilder->andWhere($where);
        }

        $queryBuilder->setParameter($this->getIndexClean(), $date->format('Y-m-d') . '%');
    }
}
