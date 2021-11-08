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

        $pVideo->IdVideo = json_decode($row['IdVideo']);
        $pVideo->RutaVideo = $nombreArchivo;

        return $pVideo;
    }
}
