<?php

use Doctrine\DBAL\Logging\DebugStack;
use phpdb\entity\Aluno;
use phpdb\helper\EntityManagerFactory;

require_once __DIR__ . "../../vendor/autoload.php";

$aluno = new Aluno();

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();
$alunosRepository = $entityManager->getRepository(Aluno::class);

$alunos = $alunosRepository->buscaCursoPorAlunoQueryBuilder();
$quant = $alunosRepository->getQuant();

// DEBUG SQL
$debugStack = new DebugStack();
$entityManager->getConfiguration()->setSQLLogger($debugStack);

foreach ($alunos as $a) {
    $telefones = $a->telefones->map(function ($telefone) {
        return $telefone->numero;
    })->toArray();
    $cursos = $a->cursos->map(function ($curso) {
        return $curso->nome;
    })->toArray();
    $telefones = implode(', ', $telefones);
    $cursos = implode(', ', $cursos);
    echo "ID: {$a->id} | Nome: {$a->nome} | Telefones: $telefones | Cursos: $cursos" . PHP_EOL;
}

print_r(PHP_EOL);
echo "$quant Resultados";

// DEBUG SQL
print_r(PHP_EOL);
// print_r($debugStack);
foreach ($debugStack->queries as $queryInfo) {
    print_r($queryInfo['sql'] . PHP_EOL);
}

print_r(PHP_EOL);
