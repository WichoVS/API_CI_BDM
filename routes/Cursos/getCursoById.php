<?php
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
require '../../controller/cursoController.php';
require "../../controller/nivelController.php";
require "../../controller/videoController.php";
require "../../controller/recursoController.php";
require "../../controller/categoriaController.php";
require_once '../../model/curso.php';
require_once "../../model/comentario.php";
require_once "../../model/cursoPresentacion.php";
require_once "../../model/categoriaCurso.php";

$endPoint = new CursoController('../../config/db.php', "../../model/curso.php", "../../model/cursoBusqueda.php", "../../model/nivel.php", "../../model/video.php", "../../model/recurso.php", "../../model/categoria.php", "../../assets");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);
$idCurso = $data->Curso;

echo json_encode($endPoint->getCurso($idCurso));
