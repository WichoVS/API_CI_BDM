<?php
require_once '../../controller/usuarioController.php';
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new UsuarioController("../../config/db.php", "../../model/usuario.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);

$id = $data->idUsuario;

echo json_encode($endPoint->getUsuario($id));
