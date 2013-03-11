Grid
===

Grid class explained.


protected $url
------------
Url that will be used for the ajax call, by defult is the same as the grid is rendered.

Use:

```php
$grid->setUrl('/url/path');
```

protected $name
------------
This attribute will be used in the template id's, for example in the div wraper.

Use:

```php
$grid->setName('My Grid');
```

abstract public function setupGrid()
------------
Use this method to construct your grid.


public function getContainer()
------------
Use this method to get the container in your grid definition.