<?php

class CursoBusqueda
{
    public $IdCurso;
    public $TituloCurso;
    public $DescrCurso;
    public $PrecioCompleto;
    public $ImagenCurso;
    public $Nombre;
    public $APaterno;
    public $AMaterno;
    public $CategoriaAsign;
    public $Likes;


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
