<?php
class Recurso
{
    public $IdRecurso;
    public $Nombre;
    public $RutaArchiv;
    public $VideoPadre;

    function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
        }

        unset($value);
    }
}
