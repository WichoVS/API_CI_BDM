<?php

class NivelesAlumnosController
{
    private $conectar;
    private $db;

    public function __construct($dir)
    {
        require_once "$dir";

        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }


    public function usuarioInscritoNivel($pIdUser, $pIdNivel)
    {
        $sql = "call UsuarioInscritoNivel($pIdUser, $pIdNivel)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            if (json_decode($row['Inscrito']) == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            echo json_decode($this->db->error);
            return false;
        }
    }
}
