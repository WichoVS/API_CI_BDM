<?php
require_once '../../controller/usuarioController.php';
// Allow CORS
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Headers: *");
}
$endPoint = new UsuarioController("../../config/db.php","../../model/usuario.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);

$correo = $data->correo;
$contra = $data->contra;

echo json_encode($endPoint->loginUsuario($correo, $contra));
