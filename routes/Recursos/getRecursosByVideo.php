<?php
require_once '../../controller/recursoController.php';
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

$endPoint = new RecursoController("../../config/db.php", "../../model/recurso.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);
$IdVideo = $data->IdVideo;

echo json_encode($endPoint->getRecursosByVideo($IdVideo));
