<?php

class AlumnoInscrito
{
    public $IdUsuario;
    public $NombreAlumno;
    public $APaternoAlumno;
    public $AMaternoAlumno;
    public $FechaInscrito;
    public $Progreso;
    public $PrecioPagado;
    public $FormaPago;



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
