<?php
namespace phpdb\entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @entity(repositoryClass="phpdb\repository\AlunoRepository")
 */
class Aluno
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
     * @oneToMany(targetEntity="Telefone", mappedBy="aluno", cascade={"remove","persist"}, fetch="EAGER")
     */
    private $telefones;

    /**
     * @manyToMany(targetEntity="Curso", mappedBy="alunos")
     */
    private $cursos;

    public function __construct()
    {
        $this->telefones = new ArrayCollection();
        $this->cursos = new ArrayCollection();
    }

    public function __get($param)
    {
        return $this->$param;
    }

    public function __set($param, $value)
    {
        $this->$param = $value;
    }

    public function addTelefone($telefone)
    {
        $this->telefones->add($telefone);
        $telefone->aluno = $this;
        return $this;
    }

    public function addCursos($curso)
    {
        if ($this->cursos->contains($curso)) {
            return;
        }

        $this->cursos->add($curso);
        $curso->addAlunos($this);
        return $this;
    }
}
