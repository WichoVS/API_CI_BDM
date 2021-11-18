<?php

class Mensaje
{
    public $IdMensaje;
    public $IdChat;
    public $IdUsuarioRecibe;
    public $IdUsuarioEnvia;
    public $FechaHora;
    public $Contenido;


    function __construct($data)
    {
        if ($data != null) {
            foreach ($data as $key => $value) {
                if (property_exists(__CLASS__, $key)) {
                    $this->$key = $value;
                }
            }

            unset($value);
        }
    }
}
