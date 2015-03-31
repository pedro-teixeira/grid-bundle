# Column Filter

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


## Filter Types

### text

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
* number_range

### date

It's a normal date filter.

### date_range

Two fields to define a date range.

Attributes:

* inputSeparator

### number_range

Two fields to define a number range.

Attributes:

* inputSeparator

### select

A select filter.

Attributes:

* options (set an array with options)
* emptyChoice
* emptyChoiceLabel

### yes_no

A select filter with "yes" and "no" options.

## Custom Filter Type

If the default filter types are not enough for your app,  you can add your own custom filter type typing the class name as the "setFilterType" argument.

```php
public function setupGrid()
{
    $this->addColumn()
        ->setFilterType('MyOwnBundle\Grid\Filter\CustomFilter');
}
```

Custom Filter Class example:

```php

namespace MyOwnBundle\Grid\Filter;

use PedroTeixeira\Bundle\GridBundle\Grid\Filter\FilterAbstract;

/**
 * Custom Filter
 */
class CustomFilter extends FilterAbstract
{
    /**
     * @return string
     */
    public function render()
    {
        return '...'; // return your custom string
    }
}
```
