<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Filter\Operator;

/**
 * Comparison
 */
class Comparison extends OperatorAbstract
{
    /**
     * @var string
     */
    protected $comparisonType = 'contain';

    /**
     * @param string|array $value
     */
    public function execute($value)
    {
        $parameter = $value;
        $queryBuilder = $this->getQueryBuilder();
        $expression = $this->getQueryBuilder()->expr();

        switch ($this->getComparisonType()) {
            case 'equal':
                $where = $expression->eq($this->getIndex(), ":{$this->getIndexClean()}");
                break;

            case 'not_equal':
                $where = $expression->neq($this->getIndex(), ":{$this->getIndexClean()}");
                break;

            case 'lower_than':
                $where = $expression->lt($this->getIndex(), ":{$this->getIndexClean()}");
                break;

            case 'lower_than_equal':
                $where = $expression->lte($this->getIndex(), ":{$this->getIndexClean()}");
                break;

            case 'greater_than':
                $where = $expression->gt($this->getIndex(), ":{$this->getIndexClean()}");
                break;

            case 'greater_than_equal':
                $where = $expression->gte($this->getIndex(), ":{$this->getIndexClean()}");
                break;

            case 'begin_with':
                $where = $expression->like($this->getIndex(), ":{$this->getIndexClean()}");
                $parameter = $value . '%';
                break;

            case 'not_begin_with':
                $where = $this->getIndex() . " NOT LIKE :{$this->getIndexClean()}";
                $parameter = $value . '%';
                break;

            case 'is_null':
                $where = $expression->orX(
                    $expression->eq(
                        $this->getIndex(),
                        ":{$this->getIndexClean()}"
                    ),
                    $this->getIndex() . ' IS NULL'
                );

                $parameter = '';
                break;

            case 'is_not_null':
                $where = $expression->andX(
                    $expression->neq(
                        $this->getIndex(),
                        ":{$this->getIndexClean()}"
                    ),
                    $this->getIndex() . ' IS NOT NULL'
                );

                $parameter = '';
                break;

            case 'in':
                if (false !== strpos($value, ',')) {

                    $where = $expression->in($this->getIndex(), ":{$this->getIndexClean()}");
                    $parameter = explode(',', $value);
                } elseif (false !== strpos($value, '-')) {

                    $where = $expression->between($this->getIndex(), ":start", ":end");

                    list($start, $end) = explode('-', $value);

                    $queryBuilder->setParameter('start', $start);
                    $queryBuilder->setParameter('end', $end);

                    unset($parameter);
                }
                break;

            case 'not_in':
                if (false !== strpos($value, ',')) {

                    $where = $expression->notIn($this->getIndex(), ":{$this->getIndexClean()}");
                    $parameter = explode(',', $value);
                } elseif (false !== strpos($value, '-')) {

                    $where = $expression->orX(
                        $this->getIndex() . "< :start",
                        $this->getIndex() . "> :end"
                    );
                    list($start, $end) = explode('-', $value);
                    $queryBuilder->setParameter('start', $start);
                    $queryBuilder->setParameter('end', $end);
                    unset($parameter);
                }

                break;

            case 'end_with':
                $where = $expression->like($this->getIndex(), ":{$this->getIndexClean()}");
                $parameter = '%' . $value;
                break;

            case 'not_end_with':
                $where = $this->getIndex() . " NOT LIKE :{$this->getIndexClean()}";
                $parameter = '%' . $value;
                break;

            case 'not_contain':
                $where = $this->getIndex() . " NOT LIKE :{$this->getIndexClean()}";
                $parameter = '%' . $value . '%';
                break;

            case 'contain':

            default:
                $where = $expression->like($this->getIndex(), ":{$this->getIndexClean()}");
                $parameter = '%' . $value . '%';
        }

        if ($this->getWhere() == 'OR') {
            $queryBuilder->orWhere($where);
        } else {
            $queryBuilder->andWhere($where);
        }

        if (isset($parameter)) {
            $queryBuilder->setParameter($this->getIndexClean(), $parameter);
        }
    }

    /**
     * @param string $comparisonType
     *
     * @return Comparison
     */
    public function setComparisonType($comparisonType)
    {
        $this->comparisonType = $comparisonType;

        return $this;
    }

    /**
     * @return string
     */
    public function getComparisonType()
    {
        return $this->comparisonType;
    }
}