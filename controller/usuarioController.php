<?php
class UsuarioController
{
    private $conectar;
    private $db;

    public function __construct($dir)
    {
        require_once "$dir";
        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function registrarUsuario($pNombre, $pAPaterno, $pAMaterno, $pCorreo, $pContra, $pFNacim, $pGenero, $pFoto, $pEscuela)
    {

        $sql = 'call registrarUsuario(\'' . $pNombre . '\', \'' . $pAPaterno . '\', \'' . $pAMaterno . '\',\'' . $pCorreo . '\',\'' . $pContra . '\',\'' . $pFNacim . '\',\'' . $pGenero . '\',\'' . $pFoto . '\',' . $pEscuela . ')';
        if ($this->db->query($sql) === TRUE) {
            $data = TRUE;
            echo json_encode(array("data" => true));
        } else {
            echo json_encode($this->db->error);
        }
    }

    public function loginUsuario($pCorreo, $pContra)
    {
        //$sql = 'call loginUsuario(\'' . $pCorreo . '\', \'' . $pContra . '\')';
        $sql = "SELECT * FROM Usuario";

        echo $sql;
        $query = $this->db->query($sql);

        if ($query) {
            echo json_encode($query);
        } else {
            echo json_encode($this->db->error);
        }
    }
}
