<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e libro.php per poterli usare
include_once '../config/database.php';
include_once '../models/timbratura.php';

// otteniamo i parametri passati con GET
$giorno = isset($_GET['giorno']) ? $_GET['giorno'] : null;

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();

// Creiamo un nuovo oggetto Timbratura
$timbratura = new Timbratura($db);

// query products
$stmt = $timbratura->read($giorno);
$num = $stmt->rowCount();

// se vengono trovate timbrature nel database
if ($num > 0) {
	// array di timbrature
	$timbrature_arr = array();
	$timbrature_arr["records"] = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // ritorna un array con indice il titolo della colonna
		extract($row); // crea la variabile con la chiave dell'array e assegna il valore
		$timbratura_item = array(
			"ID" => $ID,
			"Timbratura" => $Timbratura,
			"Causale" => $Causale
		);
		array_push($timbrature_arr["records"], $timbratura_item);
	}
	echo json_encode($timbrature_arr);
} else {
	echo json_encode(
		array("message" => "Nessuna timbratura trovata.")
	);
}
