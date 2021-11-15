<?php
require_once '../../controller/videoController.php';
// Allow CORS
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

$endPoint = new VideoController("../../config/db.php", "../../model/video.php");
$json_data = file_get_contents('php://input');

$data = json_decode($json_data);
$IdVideo = $data->IdVideo;

echo json_encode($endPoint->getVideoById($IdVideo));
