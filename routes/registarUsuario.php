<?php
require_once '../controller/usuarioController.php';

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
//$endPoint = new UsuarioController();
//echo "entra Aqui";
$model = json_decode($_POST['usuario']);

echo json_encode($model);
//$endPoint->registrarUsuario($model);