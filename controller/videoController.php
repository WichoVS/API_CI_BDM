<?php
class VideoController
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

    public function crearVideo($pIdCursoPadre, $pIdNivelPadre, $pVideo, $carpeta)
    {
        $videoB64 = $pVideo->RutaVideo;
        $strings = explode(",", $videoB64);
        $dataB64 = explode(";", $strings[0]);
        $extension = explode("/", $dataB64[0]);
        $nombreArchivo = $pIdCursoPadre . $pIdNivelPadre . $pVideo->Nombre . "." . $extension[1];

        $sql = "call crearVideo('$pVideo->Nombre', '$pVideo->Descripcion', '$nombreArchivo', $pIdCursoPadre, $pIdNivelPadre)";
        $query = $this->db->query($sql);
        if ($query) {
            $row = $query->fetch_assoc();
            if (!is_dir("$carpeta/Videos/$pIdCursoPadre/$pIdNivelPadre")) {
                mkdir("$carpeta/Videos/$pIdCursoPadre/$pIdNivelPadre", 0777, true);
            }
            $fp = file_put_contents("$carpeta/Videos/$pIdCursoPadre/$pIdNivelPadre/$nombreArchivo", base64_decode($strings[1], true));
            unset($strings);
            unset($dataB64);
        } else {
            return json_decode($this->db->error);
        }
        $this->db->close();
        $pVideo->IdVideo = json_decode($row['IdVideo']);
        $pVideo->RutaVideo = $nombreArchivo;

        return $pVideo;
    }

    public function getVideoById($pIdVideo)
    {
        $sql = "call getVideoById($pIdVideo)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $videoAux = new Video(null);
            $videoAux->IdVideo = json_decode($row['IdVideo']);
            $videoAux->Nombre = $row['Nombre'];
            $videoAux->Descripcion = $row['Descripcion'];
            $videoAux->RutaVideo = $row['RutaVideo'];
            $videoAux->CursoPadre = json_decode($row['CursoPadre']);
            $videoAux->NivelPadre = json_decode($row['NivelPadre']);
        } else {
            return json_decode($this->db->error);
        }


        return $videoAux;
    }

    public function getProximoVideo($pVideoActual)
    {
        $sql = "call getProxVideo($pVideoActual)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            $videoProx = new VideoProximo(null);
            $videoProx->IdVideo = json_decode($row['IdVideo']);
            $videoProx->Nombre = $row['Nombre'];
            $videoProx->ImagenCurso = $row['ImagenCurso'];
            $videoProx->NivelPadre = $row['NivelPadre'];
        } else {
            return json_decode($this->db->error);
        }

        return $videoProx;
    }

    public function getVideosCurso($pIdCurso)
    {
        $videos = array();
        $sql = "call getVideosCurso($pIdCurso)";
        $query = $this->db->query($sql);

        if ($query != null) {
            while ($row = $query->fetch_assoc()) {
                $auxVideo = new VideoCurso(null);
                $auxVideo->IdVideo = json_decode($row['IdVideo']);
                $auxVideo->Nombre = $row['Nombre'];
                $auxVideo->NivelPadre = json_decode($row['NivelPadre']);
                $auxVideo->Nivel = $row['Nivel'];
                array_push($videos, $auxVideo);
            }
        } else {
            return json_decode($this->db->error);
        }

        return $videos;
    }
}
