<?php
class CursoController
{
    private $conectar;
    private $db;
    private $niveles;
    private $videos;
    private $recursos;
    private $assets;

    public function __construct($dir, $model, $modelNivel, $modelVideo, $modelRecurso, $carpetaAssets)
    {
        $this->assets = $carpetaAssets;
        $this->niveles = new NivelController("$dir", "$modelNivel");
        $this->videos = new VideoController("$dir", "$modelVideo");
        $this->recursos = new RecursoController("$dir", "$modelRecurso");
        require_once "$model";
        require_once "$dir";
        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function crearCurso($pCurso)
    {

        $curso = new Curso($pCurso->CursoCrear);
        $dia = date("Ymd");

        $nameAux = str_replace("'", "\'", $curso->TituloCurso);
        $descrAux = str_replace("'", "\'", $curso->DescrCurso);
        $sql = "call crearCurso('$nameAux', '$descrAux', $curso->PrecioCompleto, '$curso->ImagenCurso', $curso->Disponible , $curso->CreadoPor, '$dia')";
        $query = $this->db->query($sql);
        if ($query) {
            $row = $query->fetch_assoc();
        } else {
            return json_decode($this->db->error);
        }
        $curso->IdCurso = json_decode($row['IdCurso']);

        foreach ($pCurso->Niveles as $value) {
            $auxNivel = new Nivel($value);
            $auxIdNivel = $auxNivel->IdNivel;
            $auxNivel =  $this->niveles->crearNivel($curso->IdCurso, $auxNivel);

            foreach ($pCurso->Videos as $video) {
                $auxVideo = new Video($video);
                $auxIdVideo = $auxVideo->IdVideo;
                if ($auxVideo->NivelPadre == $auxIdNivel) {
                    $auxVideo = $this->videos->crearVideo($curso->IdCurso, $auxNivel->IdNivel, $auxVideo, $this->assets);

                    foreach ($pCurso->Archivos as $archivo) {
                        $auxArchivo = new Recurso($archivo);
                        if ($auxArchivo->VideoPadre == $auxIdVideo) {
                            $this->recursos->crearRecurso($auxVideo->IdVideo, $auxArchivo, $this->assets);
                        }
                    }
                }
            }
        }

        return true;
    }

    public function getCurso()
    {
    }

    public function updateCurso()
    {
    }

    public function getCursoByCategoria()
    {
    }

    public function getCursoByName()
    {
    }
}
