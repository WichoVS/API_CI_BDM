<?php

class CategoriaCurso
{
    public $IdCatXCurso;
    public $CategoriaAsign;
    public $CursoAsign;
    public $Descripcion;
    public $CreadoPor;
    public $FechaCreacion;

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
