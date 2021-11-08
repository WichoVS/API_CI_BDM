<?php
class Video
{
    public $IdVideo;
    public $Nombre;
    public $Descripcion;
    public $RutaVideo;
    public $CursoPadre;
    public $NivelPadre;


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
