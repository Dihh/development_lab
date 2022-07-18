<?php

use phpdb\entity\Aluno;
use phpdb\entity\Curso;
use phpdb\helper\EntityManagerFactory;

require_once __DIR__ . "../../vendor/autoload.php";

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();

$aluno = $entityManager->find(Aluno::class, $argv[1]);
$curso = $entityManager->find(Curso::class, $argv[2]);

$aluno->addCursos($curso);

$entityManager->flush();

echo "Curso: {$curso->nome} | Aluno: {$aluno->nome}" . PHP_EOL;
