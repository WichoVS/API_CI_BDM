<?php

class ComentarioCurso
{
    public $IdComentario;
    public $CursoComentado;
    public $ComentadoPor;
    public $Nombre;
    public $APaterno;
    public $AMaterno;
    public $ImagenUsuario;
    public $Contenido;
    public $Fecha;
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
