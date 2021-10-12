<?php

class Usuario
{
    public $nombre;
    public $aPaterno;
    public $aMaterno;
    public $correo;
    public $contra;
    public $fNacim;
    public $genero;
    public $foto;
    public $escuela;
    private $conectar;
    private $db;

    public function __construct($pNombre, $pAPaterno, $pAMaterno, $pCorreo, $pContra, $pFNacim, $pGenero, $pFoto, $pEscuela)
    {
        $this->nombre = $pNombre;
        $this->aPaterno = $pAPaterno;
        $this->aMaterno = $pAMaterno;
        $this->correo = $pCorreo;
        $this->contra = $pContra;
        $this->fNacim = $pFNacim;
        $this->genero = $pGenero;
        $this->foto = $pFoto;
        $this->escuela = $pEscuela;
    }
}
