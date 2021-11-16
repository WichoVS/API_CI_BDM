<?php

class CursoInscrito
{
    public $CursoInscrito;
    public $TituloCurso;
    public $DescrCurso;
    public $ImagenCurso;
    public $Progreso;
    public $Calificacion;


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
