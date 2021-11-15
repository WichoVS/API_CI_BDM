<?php

class CursoInicio
{
    public $IdCurso;
    public $TituloCurso;
    public $ImagenCurso;


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
