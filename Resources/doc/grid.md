Grid
===

Grid class explained.


protected $url
------------
Url that will be used for the ajax call, by default is the same as the grid is rendered.

Usage:

```php
$grid->setUrl('/url/path');
```

protected $name
------------
This attribute will be used in the template id's, for example in the div wrapper.

Usage:

```php
$grid->setName('My Grid');
```

protected $exportable
------------
Enable export in the grid.

Default:

```
true
```

Usage:

```php
$grid->setExportable(false);
```

abstract public function setupGrid()
------------
Use this method to define your grid.


public function getContainer()
------------
Use this method to get the container in your grid definition.