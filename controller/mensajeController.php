<?php

class MensajeController
{
    private $conectar;
    private $db;

    public function __construct($dir, $model)
    {
        require_once "$dir";
        require_once "$model";

        $this->conectar = new Conectar();
        $this->db = $this->conectar->conexion();
    }

    public function enviaMensaje($pData)
    {
        $mensaje = new Mensaje($pData);

        $auxContent = str_replace("'", "\'", $mensaje->Contenido);
        $sql = "call enviaMensaje($mensaje->IdChat,$mensaje->IdUsuarioRecibe, $mensaje->pIdUsuarioEnvia, '$auxContent')";
        $query = $this->db->query($sql);

        if ($query != null) {
            return true;
        } else {
            echo json_decode($this->db->error);
            return false;
        }
    }

    public function getMensajesChat($pIdChat)
    {
        $mensajes = array();

        $sql = "call getMensajesChat($pIdChat)";
        $query = $this->db->query($sql);

        if ($query != null) {
            while ($rowM = $query->fetch_assoc()) {
                $aM = new Mensaje(null);
                $aM->IdMensaje = json_decode($rowM['IdMensaje']);
                $aM->IdChat = json_decode($rowM['IdChat']);
                $aM->IdUsuarioRecibe = json_decode($rowM['IdUsuarioRecibe']);
                $aM->IdUsuarioEnvia = json_decode($rowM['IdUsuarioEnvia']);
                $aM->FechaHora = $rowM['FechaHora'];
                $aM->Contenido = $rowM['IdMensaje'];

                array_push($mensaje, $aM);
            }
        } else {
            echo json_decode($this->db->error);
            return false;
        }

        return $mensajes;
    }
}
