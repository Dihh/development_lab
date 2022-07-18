<?php

use phpdb\entity\Aluno;
use phpdb\entity\Telefone;
use phpdb\helper\EntityManagerFactory;

require_once __DIR__ . "../../vendor/autoload.php";

$aluno = new Aluno();

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();

$entityManager->persist($aluno);
$aluno->nome = $argv[1];

for ($i = 2; $i < $argc; $i++) {
    $telefone = new Telefone();
    $telefone->numero = $argv[$i];
    $aluno->addTelefone($telefone);
}

$entityManager->flush();

echo "ID: {$aluno->id} - Nome: {$aluno->nome}" . PHP_EOL;
