<?php
namespace phpdb\entity;

/**
 * @entity
 */
class Telefone
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
    private $numero;
    /**
     * @manyToOne(targetEntity="Aluno")
     */
    private $aluno;

    public function __get($param)
    {
        return $this->$param;
    }

    public function __set($param, $value)
    {
        $this->$param = $value;
    }

}
