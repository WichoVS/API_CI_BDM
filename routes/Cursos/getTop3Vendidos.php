<?php
require '../../controller/cursoController.php';
require "../../controller/nivelController.php";
require "../../controller/videoController.php";
require "../../controller/recursoController.php";
require "../../controller/categoriaController.php";
require_once '../../model/curso.php';
require_once "../../model/cursoInicio.php";
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
$endPoint = new CursoController('../../config/db.php', "../../model/curso.php", "../../model/cursoBusqueda.php", "../../model/nivel.php", "../../model/video.php", "../../model/recurso.php", "../../model/categoria.php", "../../assets");


echo json_encode($endPoint->getTop3Vendidos());
