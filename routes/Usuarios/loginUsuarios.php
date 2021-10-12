<?php
require_once '../../controller/usuarioController.php';

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
$endPoint = new UsuarioController("../../config/db.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);



$endPoint->loginUsuario($data->correo, $data->contra);
