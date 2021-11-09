<?php
class RecursoController
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

    public function crearRecurso($pIdPadre, $pRecurso, $carpeta)
    {
        $archivoB64 = $pRecurso->RutaArchiv;
        $strings = explode(",", $archivoB64);


        $nombreArchivo = $pIdPadre . $pRecurso->Nombre;

        $sql = "call crearRecurso('$pRecurso->Nombre', '$nombreArchivo', $pIdPadre)";
        $query = $this->db->query($sql);
        if ($query) {
            $row = $query->fetch_assoc();
            if (!is_dir("$carpeta/Archivos/$pIdPadre")) {
                mkdir("$carpeta/Archivos/$pIdPadre", 0777, true);
            }
            $fp = file_put_contents("$carpeta/Archivos/$pIdPadre/$nombreArchivo", base64_decode($strings[1], true));
            unset($strings);
            unset($dataB64);
        } else {
            return json_decode($this->db->error);
        }
        $this->db->close();
        $pRecurso->RutaArchiv = $nombreArchivo;
        $pRecurso->IdRecurso = json_decode($row['IdRecurso']);
        return $pRecurso;
    }
}
