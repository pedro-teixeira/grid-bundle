Column Render
===

Define the render to show the values of the column.

Default:

```
text
```

Usage:

```php
public function setupGrid()
{
    $this->addColumn()
        ->setRenderType('text');
}
```

Render Types
------------

* text
* date
* date_time