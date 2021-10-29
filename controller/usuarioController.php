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
        $userR = new Usuario();
        $id = 0;
        $sql = 'call registrarUsuario(\'' . $pNombre . '\', \'' . $pAPaterno . '\', \'' . $pAMaterno . '\',\'' . $pCorreo . '\',\'' . $pContra . '\',\'' . $pFNacim . '\',\'' . $pGenero . '\',\'' . $pFoto . '\',' . $pEscuela . ')';
        $query = $this->db->query($sql);
        if ($query != null) {
            $id = $query->fetch_assoc();
        } else {
            return json_encode($this->db->error);
        }

        $idNo = json_decode($id['IdUsuario']);
        $userR->idUsuario = $idNo;

        return $userR;
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
            return json_decode($this->db->error);
        }
        $idNo = json_decode($id['IdUsuario']);
        $userR->idUsuario = $idNo;

        return $userR;
    }

    public function getUsuario($pId)
    {
        $userR = new Usuario();
        $sql = 'call getUsuarioData(\'' . $pId . '\')';

        $query = $this->db->query($sql);
        if ($query != null) {
            $auxUser = $query->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }

        //$idNo = json_decode($id['IdUsuario']);
        $userR = $auxUser;

        return $userR;
    }

    public function checkPassword($pId, $pContra)
    {
        $sql = 'call checkPassword(' . $pId . ', \'' . $pContra . '\')';

        $query = $this->db->query($sql);
        if ($query != null) {
            $row = $query->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }

        return $row;
    }

    public function updateUsuario($pId, $pNombre, $pAPaterno, $pAMaterno, $pCorreo, $pContra, $pGenero, $pFoto)
    {
        $sql = "call updateUsuario(${pId} , '${pNombre}', '${pAPaterno}', '${pAMaterno}', '${pCorreo}', '${pContra}','${pGenero}', '${pFoto}')";

        $query = $this->db->query($sql);
        if ($query != null) {
            return true;
        } else {
            return json_decode($this->db->error);
        }
    }
}
