<?php

use phpdb\entity\Aluno;
use phpdb\helper\EntityManagerFactory;

require_once __DIR__ . "../../vendor/autoload.php";

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();

$aluno = $entityManager->getReference(Aluno::class, $argv[1]);
$entityManager->remove($aluno);
$entityManager->flush();

echo "ID: {$aluno->id} - Nome: {$aluno->nome}" . PHP_EOL;
