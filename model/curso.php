<?php

class Curso
{
    public $IdCurso;
    public $TituloCurso;
    public $DescrCurso;
    public $PrecioCompleto;
    public $ImagenCurso;
    public $Disponible;
    public $CreadoPor;
    public $CreadoEn;


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
