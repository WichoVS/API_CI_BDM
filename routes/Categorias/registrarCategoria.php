<?php
require '../../controller/categoriaController.php';
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new CategoriaController("../../config/db.php", "../../model/categoria.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);
$Descripcion = $data->Descripcion;

echo json_encode($endPoint->registrarCategoria($Descripcion));
