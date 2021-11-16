<?php

class CursoToPago
{
    public $IdCurso;
    public $TituloCurso;
    public $PrecioCompleto;


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
