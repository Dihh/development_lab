<?php

use Doctrine\DBAL\Logging\DebugStack;
use phpdb\entity\Aluno;
use phpdb\helper\EntityManagerFactory;

require_once __DIR__ . "../../vendor/autoload.php";

$aluno = new Aluno();

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();

// DEBUG SQL
$debugStack = new DebugStack();
$entityManager->getConfiguration()->setSQLLogger($debugStack);

// $dql = "SELECT aluno FROM phpdb\\entity\\Aluno aluno WHERE aluno.id = 7 OR aluno.nome = 'Diegton'";
// $query = $entityManager->createQuery($dql);
// $alunos = $query->getResult();

$alunosRepository = $entityManager->getRepository(Aluno::class);
$alunos = $alunosRepository->findAll(); /* SELECT * */

// $alunos = $alunosRepository->findBy([
//     'nome' => 'Ademar',
// ]); /* SELECT WHERE */

// $alunos = $alunosRepository->findOneBy([
//     'nome' => 'Ademar',
// ]); /* SELECT FIRST */

// $alunos = $alunosRepository->find(1); /* SELECT BY ID */

foreach ($alunos as $a) {
    $telefones = $a->telefones->map(function ($telefone) {
        return $telefone->numero;
    })->toArray();
    $telefones = implode(', ', $telefones);
    echo "ID: {$a->id} | Nome: {$a->nome} | Telefones: $telefones" . PHP_EOL;
}

print_r(PHP_EOL);
// print_r($debugStack);

foreach ($debugStack->queries as $queryInfo) {
    print_r($queryInfo['sql'] . PHP_EOL);
}
