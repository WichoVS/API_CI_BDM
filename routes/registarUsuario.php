<?php
require '../controller/usuarioController.php';
require_once '../model/usuario.php';
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new UsuarioController("../config/db.php", "../model/usuario.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);

$nombre = $data->nombre;
$aPaterno = $data->aPaterno;
$aMaterno = $data->aMaterno;
$correo = $data->correo;
$contra = $data->contra;
$fNacim = $data->fNacim;
$genero = $data->genero;
$foto = $data->foto;
$escuela = $data->escuela;

echo json_encode($endPoint->registrarUsuario($nombre, $aPaterno, $aMaterno, $correo, $contra, $fNacim, $genero, $foto, $escuela));
