<?php

class UsuarioChat
{
    public $IdChat;
    public $IdEmisor;
    public $IdReceptor;
    public $Nombre;
    public $APaterno;
    public $AMaterno;
    public $ImagenUsuario;
    public $UltimoMensaje;

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
