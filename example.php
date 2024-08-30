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
