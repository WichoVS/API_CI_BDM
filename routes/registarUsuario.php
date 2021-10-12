<?php
require '../controller/usuarioController.php';
require_once '../model/usuario.php';
// Allow CORS
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Headers: *");
}
$endPoint = new UsuarioController("../config/db.php");
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


//echo json_encode(array("data" => $nombre));

//$data = json_decode($json_data, true);
//$data["nombre"];

// $nombre = $_POST["nombre"]; 
// $aPaterno = $data['aPaterno'];
// $aMaterno = $data['aMaterno'];
// $correo = $data['correo'];
// $contra = $data['contra'];
// $fNacim = $data['fNacim'];
// $genero = $data['genero'];
// $foto = $data['foto'];
// $escuela = $data['escuela'];

//echo $nombre;
//$model = new Usuario($nombre, $aPaterno, $aMaterno, $correo, $contra, $fNacim, $genero, $foto, $escuela);



$endPoint->registrarUsuario($nombre, $aPaterno, $aMaterno, $correo, $contra, $fNacim, $genero, $foto, $escuela);
