<?php
class CategoriaController
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

    public function registrarCategoria($pCategoria)
    {
        $Catego = new Categoria();
        $id = 0;
        $sql = 'call registrarCategoria(\'' . $pCategoria . '\')';
        $query = $this->db->query($sql);
        if ($query != null) {
            $id = $query->fetch_assoc();
        } else {
            return json_encode($this->db->error);
        }

        $idNo = json_decode($id['IdCategoria']);
        $Catego->idCategoria = $idNo;

        return $Catego;
    }

    public function getCategoria()
    {
        $Catego = new Categoria();
        $sql = 'call getCategoria()';

        $query = $this->db->query($sql);
        if ($query != null) {
            $aux = $query->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }

        //$idNo = json_decode($id['IdUsuario']);
        $Catego = $aux;

        return $Catego;
    }
}
