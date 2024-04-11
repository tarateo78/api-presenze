<?php

//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/timbratura.php';

$database = new Database();
$db = $database->getConnection();

$timbratura = new Timbratura($db);
$data = json_decode(file_get_contents("php://input"));

if (
	//!empty($data->ID) &&
	!empty($data->Timbratura) &&
	!empty($data->Causale)
) {
	//$timbratura->ID = $data->ID;
	$timbratura->Timbratura = $data->Timbratura;
	$timbratura->Causale = $data->Causale;

	if ($timbratura->create()) {
		http_response_code(201);
		echo json_encode(array("message" => "Timbratura creato correttamente."));
	} else {
		//503 servizio non disponibile
		http_response_code(503);
		echo json_encode(array("message" => "Impossibile creare la timbratura."));
	}
} else {
	//400 bad request
	http_response_code(400);
	echo json_encode(array("message" => "Impossibile creare la timbratura i dati sono incompleti."));
}
