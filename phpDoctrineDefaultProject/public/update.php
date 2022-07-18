<?php

use phpdb\entity\Aluno;
use phpdb\helper\EntityManagerFactory;

require_once __DIR__ . "../../vendor/autoload.php";

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();

$aluno = $entityManager->find(Aluno::class, $argv[1]);
$aluno->nome = $argv[2];
$entityManager->flush();

echo "ID: {$aluno->id} - Nome: {$aluno->nome}" . PHP_EOL;
