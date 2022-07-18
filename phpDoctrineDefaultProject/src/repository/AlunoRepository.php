<?php
namespace phpdb\repository;

use Doctrine\ORM\EntityRepository;
use phpdb\entity\Aluno;

class AlunoRepository extends EntityRepository
{
    public function buscaCursoPorAluno()
    {

        $entityManager = $this->getEntityManager();
        $classAluno = Aluno::class;
        $dql = "SELECT aluno, telefones, cursos FROM $classAluno aluno LEFT JOIN aluno.telefones telefones LEFT JOIN aluno.cursos cursos";
        $query = $entityManager->createQuery($dql);
        return $query->getResult();
    }

    public function buscaCursoPorAlunoQueryBuilder()
    {

        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.telefones', 't')
            ->leftJoin('a.cursos', 'c')
            ->addSelect('t')
            ->addSelect('c')
            ->getQuery();

        return $query->getResult();
    }

    public function getQuant()
    {
        $entityManager = $this->getEntityManager();
        $classAluno = Aluno::class;
        $dql = "SELECT COUNT(aluno) FROM $classAluno aluno";
        $query = $entityManager->createQuery($dql);
        return $query->getSingleScalarResult();
    }
}
