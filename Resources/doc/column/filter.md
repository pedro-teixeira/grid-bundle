Column Filter
===

Define the filter type for the column.

Default:

```
text
```

Usage:

```php
public function setupGrid()
{
    $this->addColumn()
        ->setFilterType('text');
}
```


Filter Types
===

text
------------

It's a normal input filter.

Attributes:

* placeholder

Operator:

```php
public function setupGrid()
{
    $this->addColumn('ID')
        ->getFilter()
            ->getOperator()
                ->setComparisonType('equal');
}
```

Operator Comparison Types:

* (default) contain
* equal
* not_equal
* lower_than
* lower_than_equal
* greater_than
* greater_than_equal
* begin_with
* not_begin_with
* is_null
* is_not_null
* in
* not_in
* end_with
* not_end_with
* not_contain

date
------------

It's a normal date filter.

date_range
------------

Two fields to define a date range.

Attributes:

* fromLabel
* toLabel

select
------------

A select filter.

Attributes:

* options (set an array with options)
* emptyChoice
* emptyChoiceLabel

yes_no
------------

A select filter with "yes" and "no" options.

