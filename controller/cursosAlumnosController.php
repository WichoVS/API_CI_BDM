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
                $cursoAux->IdCurso = json_decode($row['IdCurso']);
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

    public function getCursoAlumnos($pIdCurso)
    {
        $cursoAlumnos = new CursoAlumnosCreado(null);
        $sqlC = "call getCursoCreado($pIdCurso)";
        $queryC = $this->db->query($sqlC);


        if ($queryC != null) {
            $rowC = $queryC->fetch_assoc();
            $cursoAlumnos->IdCurso = json_decode($rowC['IdCurso']);
            $cursoAlumnos->TituloCurso = $rowC['TituloCurso'];
            $cursoAlumnos->IngresosTotales = json_decode($rowC['IngresosTotales']);
            $cursoAlumnos->Alumnos = array();
        } else {
            return json_decode($this->db->error);
        }
        $this->db->close();

        $this->db = $this->conectar->conexion();

        $sqlA = "call getAlumnosInscritos($pIdCurso)";
        $queryA = $this->db->query($sqlA);

        if ($queryA != null) {
            while ($rowA = $queryA->fetch_assoc()) {
                $aAlum = new AlumnoInscrito(null);
                $aAlum->IdUsuario = json_decode($rowA['IdUsuario']);
                $aAlum->NombreAlumno = $rowA['NombreAlumno'];
                $aAlum->APaternoAlumno = $rowA['APaternoAlumno'];
                $aAlum->AMaternoAlumno = $rowA['AMaternoAlumno'];
                $aAlum->FechaInscrito = $rowA['FechaInscrito'];
                $aAlum->Progreso = json_decode($rowA['Progreso']);
                $aAlum->PrecioPagado = json_decode($rowA['PrecioPagado']);
                $aAlum->FormaPago = $rowA['FormaPago'];


                array_push($cursoAlumnos->Alumnos, $aAlum);
            }
        }

        return $cursoAlumnos;
    }

    public function usuarioInscritoCurso($pIdUser, $pIdCurso)
    {
        $sql = "call UsuarioInscritoCurso($pIdUser, $pIdCurso)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();

            if ($query->num_rows == 1) {
                $this->db->close();
                return true;
            } else {
                $this->db->close();
                return false;
            }
        } else {
            echo json_decode($this->db->error);
            $this->db->close();
            return false;
        }
    }

    public function ActualizaProgreso($pData)
    {

        $sql = "call actualizaProgreso($pData->IdUsuario, $pData->IdCurso, $pData->IdVideo, $pData->IdNivel)";
        $query = $this->db->query($sql);


        if ($query != null) {
            return true;
        } else {
            echo json_encode($this->db->error);
            return false;
        }
    }
}
