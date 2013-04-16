Column
===

Column class explained.

protected $name
------------

Used as a column name in your grid.

Usage:

```php
public function setupGrid()
{
    $this->addColumn('Column Name');
}
```

protected $field
------------

It's the field name of your entity.

Usage:

```php
public function setupGrid()
{
    $this->addColumn()
        ->setField('test');
}
```

protected $index
------------

It's the index name used in your query builder.

Usage:

```php
public function setupGrid()
{
    $this->addColumn()
        ->setIndex('r.test');
}
```

protected $twig
------------

If you want to use a twig template for this column define this field.

Usage:

```php
public function setupGrid()
{
    $this->addColumn()
        ->setTwig('TestBundle:Test:template.html.twig')
        ->setFilterType(false);
}
```

protected $sortable
------------

Set the field as sortable.

Default:

```
true
```

Usage:

```php
public function setupGrid()
{
    $this->addColumn()
        ->setSortable(false);
}
```

protected $exportOnly
------------

Just show the field in the export.

Default:

```
false
```

Usage:

```php
public function setupGrid()
{
    $this->addColumn()
        ->setExportOnly(true);
}
```

protected $filterType
------------

Referrer to [Column Filter](https://github.com/pedro-teixeira/grid-bundle/tree/master/Resources/doc/column/filter.md)


protected $renderType
------------

Referrer to [Column Render](https://github.com/pedro-teixeira/grid-bundle/tree/master/Resources/doc/column/render.md)