# Column Render

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

## Render Types

* text
* date
* date_time
* url
* yes_no
* currency

## Custom Render Type

If the default render types are not enough for your app,  you can add your own custom render type typing the class name as the "setRenderType" argument.

```php
public function setupGrid()
{
    $this->addColumn()
        ->setRenderType('MyOwnBundle\Grid\Render\ToUpper');
}
```

Custom Render Class example:

```php

namespace MyOwnBundle\Grid\Render;

use PedroTeixeira\Bundle\GridBundle\Grid\Render\RenderAbstract;

/**
 * Custom Render
 */
class ToUpper extends RenderAbstract
{
    /**
     * @return string
     */
    public function render()
    {
        return strtoupper($this->getValue());
    }
}
```
