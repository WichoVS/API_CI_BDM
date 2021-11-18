<?php
class ComentarioController
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

    public function calificaCurso($pData)
    {

        $comentario = new Comentario($pData->Comentario);


        $auxContent = str_replace("'", "\'", $comentario->Contenido);
        $sql = "call calificaCurso($comentario->CursoComentado, $comentario->ComentadoPor, '$auxContent', $pData->Calificacion)";
        $query = $this->db->query($sql);

        if ($query != null) {
            return true;
        } else {
            echo json_decode($this->db->error);
            return false;
        }
    }
}
