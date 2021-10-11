<?php
require_once '../../controller/usuarioController.php';

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
$endPoint = new UsuarioController();
$json_data = file_get_contents('php://input');
$model = json_decode($json_data);

$endPoint->loginUsuario($model, $model);
