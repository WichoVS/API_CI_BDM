<?php

class NivelController
{
    private $conectar;
    private $db;

    public function __construct($dir, $model)
    {
        require_once "$dir";
        require_once "$model";

        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function crearNivel($pCursoPadre, $pNivel)
    {

        $auxSql = "call crearNivel('$pNivel->Nombre', $pNivel->Costo, $pCursoPadre)";
        $auxQuery = $this->db->query($auxSql);
        if ($auxQuery) {
            $row = $auxQuery->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }
        $pNivel->IdNivel = json_decode($row['IdNivel']);

        return $pNivel;
    }
}
