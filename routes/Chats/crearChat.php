<?php
require_once '../../controller/chatController.php';
require_once "../../model/chat.php";
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new ChatController("../../config/db.php", "../../model/usuarioChat.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);

echo json_encode($endPoint->crearChat($data));
