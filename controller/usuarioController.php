<?php
class UsuarioController
{
    private $conectar;
    private $db;

    public function __construct()
    {
        require_once '../config/db.php';
        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function registrarUsuario($pUsuario)
    {
        $pNombre = $pUsuario->nombre;
        $pAPaterno = $pUsuario->aPaterno;
        $pAMaterno = $pUsuario->aMaterno;
        $pCorreo = $pUsuario->correo;
        $pContra = $pUsuario->contra;
        $pFNacim = $pUsuario->fNacim;
        $pGenero = $pUsuario->genero;
        $pFoto = "";
        $pEscuela = 0;

        $sql = 'call registrarUsuario(\'' . $pNombre . '\', \'' . $pAPaterno . '\', \'' . $pAMaterno . '\',\'' . $pCorreo . '\',\'' . $pContra . '\',\'' . $pFNacim . '\',\'' . $pGenero . '\',\'' . $pFoto . '\',' . $pEscuela . ')';
        echo $sql;
        if ($this->db->query($sql) === TRUE) {
            echo json_encode(true);
        } else {
            echo json_encode($this->db->error);
        }
    }

    public function loginUsuario($pCorreo, $pContra)
    {
        $sql = "call loginUsuario(${pCorreo},${pContra})";

        $query = $this->db->query($sql);

        if ($query) {
            echo json_encode($query);
        } else {
            echo json_encode(FALSE);
        }
    }
}
