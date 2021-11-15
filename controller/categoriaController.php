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
        $categoria = new Categoria($pCategoria);
        $sql = 'call registrarCategoria(\'' . $categoria->Descripcion . '\')';
        $query = $this->db->query($sql);
        if ($query != null) {
            $id = $query->fetch_assoc();
        } else {
            return json_encode($this->db->error);
        }
        return json_decode($id['IdCategoria']);
    }

    public function getCategoria()
    {
        $categorias = array();
        $sql = 'call getCategoria()';

        $query = $this->db->query($sql);
        if ($query != null) {
            while ($row = $query->fetch_assoc()) {
                $auxCatego = new Categoria(null);
                $auxCatego->IdCategoria = json_decode($row['IdCategoria']);
                $auxCatego->Descripcion = $row['Descripcion'];
                array_push($categorias, $auxCatego);
            }
        } else {
            return json_decode($this->db->error);
        }


        return $categorias;
    }


    public function getCategoriaById($id)
    {
        $Catego = new Categoria(null);
        $sql = "call getCategoriaById($id)";
        $query = $this->db->query($sql);
        if ($query != null) {
            $aux = $query->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }

        $Catego->IdCategoria = json_decode($aux['IdCategoria']);
        $Catego->Descripcion = $aux['Descripcion'];

        return $Catego;
    }

    public function addCategoriaCurso($pCat, $pCurso, $pUser)
    {

        $sql = "call addCategoriaCurso($pCat, $pCurso, $pUser)";
        $query = $this->db->query($sql);
        if ($query != null) {
            $aux = $query->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }
        $this->db->close();
        return json_decode($aux['IdCatCurso']);
    }
}
