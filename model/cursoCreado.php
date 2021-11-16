<?php

class CursoCreado
{
    public $IdCurso;
    public $TituloCurso;
    public $DescrCurso;
    public $ImagenCurso;
    public $AlumnosInscritos;
    public $Promedio;
    public $IngresosTotales;


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
