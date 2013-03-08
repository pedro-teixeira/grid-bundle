<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

use DoctrineExtensions\Paginate\Paginate;

use Symfony\Component\HttpFoundation\Response;

/**
 * Grid Abstract
 */
abstract class GridAbstract
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var \Symfony\Component\Routing\Router
     */
    protected $router;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var \Twig_TemplateInterface
     */
    protected $templating;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var bool
     */
    protected $ajax;

    /**
     * @var string
     */
    protected $name;

    /**
     * Setup grid, the place to add columns and options
     */
    abstract public function setupGrid();

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     *
     * @return \PedroTeixeira\Bundle\GridBundle\Grid\GridAbstract
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;

        $this->router = $this->container->get('router');
        $this->request = $this->container->get('request');
        $this->templating = $this->container->get('templating');

        $this->columns = array();
        $this->url = null;
        $this->ajax = $this->request->isXmlHttpRequest() ? true : false;

        $now = new \DateTime();
        $this->name = md5($now->format('Y-m-d H:i:s:u'));
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return bool If true (Ajax Request), returns json. Else (Regular request), renders html
     */
    public function isAjax()
    {
        return $this->ajax;
    }

    /**
     * @param string $name
     *
     * @return GridAbstract
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
     * @param string $url
     *
     * @return GridAbstract
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if (!$this->url) {
            $this->url = $this->router->generate($this->request->get('_route'));
        }

        return $this->url;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     *
     * @return GridAbstract
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder)
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
     * @param string $name
     *
     * @return Column
     */
    public function addColumn($name)
    {
        $column = new Column($this->container, $name);

        $this->columns[] = $column;

        return $column;
    }

    /**
     * Return an array with column definitions
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Return columns count
     *
     * @return int
     */
    public function getColumnsCount()
    {
        return count($this->getColumns());
    }

    /**
     * Process the filters and return the result
     *
     * @return array
     */
    public function getData()
    {
        $page       = $this->request->query->get('page', 1);
        $limit      = $this->request->query->get('limit', 10);
        $limit      = intval(abs($limit));
        $sortIndex  = $this->request->query->get('sort');
        $sortOrder  = $this->request->query->get('sort_order');
        $filters    = $this->request->query->get('filters');

        foreach ($filters as $filter) {
            /** @var \PedroTeixeira\Bundle\GridBundle\Grid\Column $column */
            foreach ($this->columns as $column) {
                if ($filter['name'] == $column->getIndex() && !empty($filter['value'])) {
                    $column->getFilter()->execute($this->getQueryBuilder(), $filter['value']);
                }
            }
        }

        if ($sortIndex) {
            $this->getQueryBuilder()->orderBy($sortIndex, $sortOrder);
        }

        $totalCount = Paginate::count($this->getQueryBuilder()->getQuery());

        $totalPages = ceil($totalCount / $limit);

        $queryOffset = (($page * $limit) - $limit);

        $this->getQueryBuilder()
            ->setFirstResult($queryOffset)
            ->setMaxResults($limit);

        $response = array(
            'page'          => $page,
            'page_count'    => $totalPages,
            'row_count'     => $totalCount
        );

        foreach ($this->getQueryBuilder()->getQuery()->getResult() as $key => $row) {

            $rowValue = array();

            /** @var Column $column */
            foreach ($this->columns as $column) {

                $rowColumn = ' ';

                // Object
                if (method_exists($row, 'get' . ucfirst($column->getIndex()))) {

                    $method = 'get' . ucfirst($column->getIndex());
                    $rowColumn = $row->$method();

                // Array
                } else if (array_key_exists($column->getIndex(), $row)) {

                    $rowColumn = $row[$column->getIndex()];

                // Array scalar
                } else if (array_key_exists(0, $row) && array_key_exists($column->getIndex(), $row[0])) {

                    $rowColumn = $row[0][$column->getIndex()];

                // Twig
                } else if ($column->getTwig()) {

                    $rowColumn = $this->templating->render(
                        $column->getTwig(),
                        array(
                            'row' => $row
                        )
                    );
                }

                $rowValue[$column->getIndex()] = $column->getRender()->setValue($rowColumn)->render();
            }

            $response['rows'][$key] = $rowValue;
        }

        return $response;
    }

    /**
     * Returns the an array with a GridView instance for normal requests and json for AJAX requests
     *
     * @return GridView | \Symfony\Component\HttpFoundation\Response
     */
    public function render()
    {
        if ($this->isAjax()) {

            $data = $this->getData();
            $json = json_encode($data);

            $response = new Response();
            $response->setContent($json);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        } else {
            return new GridView($this);
        }
    }
}