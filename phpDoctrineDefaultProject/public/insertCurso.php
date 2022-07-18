<?php

use phpdb\entity\Curso;
use phpdb\helper\EntityManagerFactory;

require_once __DIR__ . "../../vendor/autoload.php";

$curso = new Curso();

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();

$entityManager->persist($curso);
$curso->nome = $argv[1];

$entityManager->flush();

echo "ID: {$curso->id} - Nome: {$curso->nome}" . PHP_EOL;
