<?php

class ChatController
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

    public function crearChat($pChatCrear)
    {
        $chat = new Chat($pChatCrear);

        $auxCont = str_replace("'", "\'", $chat->UltimoMensaje);
        $sql = "call crearChat($chat->IdEmisor, $chat->IdReceptor, '$auxCont')";
        $query = $this->db->query($sql);

        if ($query != null) {
            return true;
        } else {
            echo json_encode($this->db->error);
            return false;
        }
    }

    public function checkChatExiste($pIdEmisor, $pIdReceptor)
    {
        $sql = "call checkChatExiste($pIdEmisor, $pIdReceptor)";
        $query = $this->db->query($sql);

        if ($query != null) {
            $row = $query->fetch_assoc();
            return json_decode($row['existe']);
        } else {
            echo json_encode($this->db->error);
            return false;
        }
    }

    public function getIdChat($pIdEmisor, $pIdReceptor)
    {
        $sql = "call getIdChat($pIdEmisor, $pIdReceptor)";

        $query = $this->db->query($sql);
        if ($query != null) {
            $row = $query->fetch_assoc();
            return json_decode($row['IdChat']);
        } else {
            echo json_encode($this->db->error);
            return false;
        }
    }

    public function getMyChats($pIdEmisor)
    {
        $chats = array();
        $sql = "call getMyChats($pIdEmisor)";
        $query = $this->db->query($sql);

        if ($query != null) {
            while ($rowC = $query->fetch_assoc()) {
                $aC = new UsuarioChat(null);
                $aC->IdChat = json_decode($rowC['IdChat']);
                $aC->IdEmisor = json_decode($rowC['IdEmisor']);
                $aC->IdReceptor = json_decode($rowC['IdReceptor']);
                $aC->Nombre = $rowC['Nombre'];
                $aC->APaterno = $rowC['APaterno'];
                $aC->AMaterno = $rowC['AMaterno'];
                $aC->ImagenUsuario = $rowC['ImagenUsuario'];
                $aC->UltimoMensaje = $rowC['UltimoMensaje'];

                array_push($chats, $aC);
            }
        } else {
            echo json_encode($this->db->error);
            return false;
        }

        return $chats;
    }
}
