# DynamicTable v1.0.5
A simple PHP class to generate dynamic HTML tables from a multidimensional associative array. This class provides various methods to manipulate table headers, add custom columns, and style the table with CSS classes.

## Installation

```bash
composer require vanetten/dynamictable
```

## Basic Usage
```php
<?php
require_once 'vendor/autoload.php';
$data = [
    ['id' => 0, 'name' => 'Henry', 'age' => 42, 'city' => 'Boulder'],
    ['id' => 1, 'name' => 'Ned', 'age' => 40, 'city' => 'Los Angeles'],
    ['id' => 2, 'name' => 'Delilah', 'age' => 43, 'city' => 'Chicago'],
];
$dt = new \VanEtten\DynamicTable($data);
$html = $dt->render();
echo $html;
?>
```
> output

| id  |  name   | age | city        |
| :-- | :-----: | --: | ----------- |
| 0   |  Henry  |  42 | Boulder     |
| 1   |   Ned   |  40 | Los Angeles |
| 2   | Delilah |  43 | Chicago     |

## Advanced Example
You can chain multiple methods to manipulate the table headers and add custom columns:

```php

# In the addHeader method, use {{ }} to reference any existing key.

$dt->renameHeaders(['name' => 'Full Name'])
    ->addHeader(['Action' => '<a href="delete.php?id={{id}}">Delete</a>]')
    ->headerToUpperCase()
    ->excludeHeaders('id')
    ->addTableClass('table-class')
    ->addHeaderClass('header-class')
    ->addBodyClass('body-class');
```

> output

|  FULL NAME | AGE | CITY        |ACTION     |
| :--------: | --: | ----------- |-----------|
|  Henry     |  42 | Boulder     |[Delete](delete.php?id=0)|       
|   Ned      |  40 | Los Angeles |[Delete](delete.php?id=1)|
| Delilah    |  43 | Chicago     |[Delete](delete.php?id=2)|

