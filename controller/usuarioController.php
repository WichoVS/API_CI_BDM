<?php
class UsuarioController
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
        $userR = new Usuario();
        $id = 0;
        $sql = 'call loginUsuario(\'' . $pCorreo . '\', \'' . $pContra . '\')';

        $query = $this->db->query($sql);
        if ($query != null) {
            $id = $query->fetch_assoc();
        } else {
            echo json_decode($this->db->error);
        }
        $idNo = json_decode($id['IdUsuario']);
        $userR->idUsuario = $idNo;

        return $userR;
    }
}
