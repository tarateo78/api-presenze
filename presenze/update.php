<?php

// HEADERS
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

$timbratura->id = $dati->id;
$timbratura->data = $dati->data;
$timbratura->ora = $dati->ora;
$timbratura->causale = $dati->causale;

if ($timbratura->update()) {
	http_response_code(200);
	echo json_encode(array("risposta" => "Timbratura aggiornata"));
} else {
	//503 service unavailable
	http_response_code(503);
	echo json_encode(array("risposta" => "Impossibile aggiornare la Timbratura"));
}
