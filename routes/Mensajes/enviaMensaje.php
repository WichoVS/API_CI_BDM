<?php
require_once '../../controller/mensajeController.php';
//require_once "../../model/mensaje.php";
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new MensajeController("../../config/db.php", "../../model/mensaje.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);

echo json_encode($endPoint->enviaMensaje($data));
