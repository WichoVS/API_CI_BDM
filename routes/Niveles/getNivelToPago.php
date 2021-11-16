<?php
require '../../controller/nivelController.php';
require_once "../../model/nivelToPago.php";

// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new NivelController('../../config/db.php', "../../model/nivel.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);
$idNivel = $data->Nivel;

echo json_encode($endPoint->getNivelToPago($idNivel));
