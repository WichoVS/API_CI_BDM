<?php

class Chat
{
    public $IdChat;
    public $IdEmisor;
    public $IdReceptor;
    public $UltimoMensaje;
    public $UltimaActividad;

    function __construct($data)
    {
        if ($data != null)
            foreach ($data as $key => $value) {
                if (property_exists(__CLASS__, $key)) {
                    $this->$key = $value;
                }
            }

        unset($value);
    }
}
