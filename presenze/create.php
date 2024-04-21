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
$dati = json_decode(file_get_contents("php://input"));
// echo json_encode(array("message" => "cazuri"));

if (
	//!empty($dati->ID) &&
	!empty($dati->data) &&
	!empty($dati->ora) &&
	!empty($dati->causale)
) {
	//$timbratura->ID = $dati->ID;
	$timbratura->data = $dati->data;
	$timbratura->ora = $dati->ora;
	$timbratura->causale = $dati->causale;

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
