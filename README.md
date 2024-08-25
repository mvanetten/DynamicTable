# Dynamic Table
A simple PHP class to generate dynamic HTML tables from a multidimensional associative array. This class provides various methods to manipulate table headers, add custom columns, and style the table with CSS classes.

## Installation

Clone the repository or download the `Table.php` file and include it in your project.

```bash
git clone https://github.com/mvanetten/dynamictable.git
```
## Basic Usage
```php
<?php
 require 'Table.php';
 $data = [
     ['id' => 0, 'name' => 'Henry', 'age' => 42, 'city' => 'Boulder'],
     ['id' => 1, 'name' => 'Ned', 'age' => 40, 'city' => 'Los Angeles'],
     ['id' => 2, 'name' => 'Delilah', 'age' => 43, 'city' => 'Chicago'],
 ];
 
 $table = new Table($data);
 $table->HTML();
?>
```

## Advanced Example
You can chain multiple methods to manipulate the table headers and add custom columns:

```php
$table->renameHeaders(['name' => 'Full Name'])
    ->addHeader('Action', function($row) {
        return '<a href="delete.php?id={{id}}">Delete</a>';
    })
    ->headerToUpperCase()
    ->excludeHeaders('id')
    ->addTableClass('table-class')
    ->addHeaderClass('header-class')
    ->addBodyClass('body-class')
    ->HTML();
```
In the addHeader method, use {{ }} to reference any existing key.
