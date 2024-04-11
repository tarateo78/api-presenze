<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/libro.php';

$database = new Database();
$db = $database->getConnection();

$libro = new Libro($db);

$data = json_decode(file_get_contents("php://input"));

$libro->ISBN = $data->ISBN;

if ($libro->delete()) {
	http_response_code(200);
	echo json_encode(array("risposta" => "Il libro e' stato eliminato"));
} else {
	//503 service unavailable
	http_response_code(503);
	echo json_encode(array("risposta" => "Impossibile eliminare il libro."));
}
