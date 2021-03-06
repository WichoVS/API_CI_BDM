<?php

class Diploma
{
    public $Nombre;
    public $APaterno;
    public $AMaterno;
    public $TituloCurso;
    public $Firma;

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
