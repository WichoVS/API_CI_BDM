<?php
require '../../controller/cursoController.php';
require_once '../../model/curso.php';
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new CursoController('../../config/db.php', "../../model/curso.php");
$json_data = file_get_contents('php://input');

echo json_decode($json_data, true);
