<?php

require_once __DIR__ . "/vendor/autoload.php";

// PDO
$connection = new \PDO("sqlite:src/var/data/phpdb.db");
$result = $connection->query("SELECT * FROM ALUNO");
$data = $result->fetchAll();
echo '<pre>';
var_dump($data);
echo '</pre>';
