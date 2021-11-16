<?php

class CursosAlumnosController
{
    private $conectar;
    private $db;

    public function __construct($dir)
    {
        require_once "$dir";

        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function getCursosInscritos($pIdUsuario)
    {
        $cursosIns = array();
        $sql = "call getCursosInscritos($pIdUsuario)";
        $query = $this->db->query($sql);

        if ($query != null) {
            while ($row = $query->fetch_assoc()) {
                $cursoAux = new CursoInscrito(null);
                $cursoAux->CursoInscrito = json_decode($row['CursoInscrito']);
                $cursoAux->TituloCurso = $row['TituloCurso'];
                $cursoAux->DescrCurso = $row['DescrCurso'];
                $cursoAux->ImagenCurso = $row['ImagenCurso'];
                $cursoAux->Progreso = json_decode($row['Progreso']);
                $cursoAux->Calificacion = json_decode($row['Calificacion']);

                array_push($cursosIns, $cursoAux);
            }
        } else {
            return json_decode($this->db->error);
        }

        return $cursosIns;
    }

    public function getNivelToPago($pIdNivel)
    {
    }
}
