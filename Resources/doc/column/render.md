Column Render
===

Define the the render to show the values of the column.

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

Filter Types
------------

* text
* date
* date_time