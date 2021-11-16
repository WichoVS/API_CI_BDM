<?php
require '../../controller/cursosAlumnosController.php';
require_once "../../model/cursoInscrito.php";

// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new CursosAlumnosController('../../config/db.php');
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);
$idUsuario = $data->Usuario;

echo json_encode($endPoint->getCursosInscritos($idUsuario));
