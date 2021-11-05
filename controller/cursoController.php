<?php
class CursoController
{
    private $conectar;
    private $db;

    public function __construct($dir, $model)
    {
        require_once "$model";
        require_once "$dir";
        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function crearCurso()
    {
    }

    public function getCurso()
    {
    }

    public function updateCurso()
    {
    }

    public function getCursoByCategoria()
    {
    }

    public function getCursoByName()
    {
    }
}
