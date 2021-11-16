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
            echo json_encode($this->db->error);
            return json_decode($this->db->error);
        }
        $this->db->close();
        $pNivel->IdNivel = json_decode($row['IdNivel']);
        return $pNivel;
    }

    public function getNivelToPago($pIdNivel)
    {

        $nivel = new NivelToPago(null);

        $sql = "call getNivelToPago($pIdNivel)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $nivel->IdNivel = json_decode($row['IdNivel']);
            $nivel->Nombre = $row['Nombre'];
            $nivel->Costo = json_decode($row['Costo']);
        } else {
            return json_decode($this->db->error);
        }

        return $nivel;
    }
}
