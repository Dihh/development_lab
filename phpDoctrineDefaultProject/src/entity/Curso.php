<?php
namespace phpdb\entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @entity
 */
class Curso
{
    /**
     * @Id
     * @GeneratedValue
     * @column (type="integer")
     */
    private $id;
    /**
     * @column (type="string")
     */
    private $nome;
    /**
     * @manyToMany(targetEntity="Aluno", inversedBy="cursos")
     */
    private $alunos;

    public function __construct()
    {
        $this->alunos = new ArrayCollection();
    }

    public function __get($param)
    {
        return $this->$param;
    }

    public function __set($param, $value)
    {
        $this->$param = $value;
    }

    public function addAlunos($aluno)
    {
        if ($this->alunos->contains($aluno)) {
            return;
        }
        $this->alunos->add($aluno);
        $aluno->addCursos($this);
        return $this;
    }
}
