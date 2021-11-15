<?php

class Comentario
{
    public $IdComentario;
    public $CursoComentado;
    public $ComentadoPor;
    public $Contenido;
    public $Fecha;

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
