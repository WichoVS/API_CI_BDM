<?php

class CursoAlumnosCreado
{
    public $IdCurso;
    public $TituloCurso;
    public $IngresosTotales;
    public $Alumnos;


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
