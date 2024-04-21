<?php
class Timbratura
{
	private $conn;
	private $table_name = "api_presenze";

	// proprietà di una timbratura
	public $id;
	public $data;
	public $ora;
	public $causale;

	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}

	// READ timbrature
	function read($parametri)
	{

		// assegno i parametri passati alle relative variabili/indice array
		extract($parametri);

		// QUERY
		$query = "SELECT a.id, a.data, a.ora, a.causale FROM " . $this->table_name . " a ";
		$query .= " WHERE 1 ";

		// PARAMETRI
		if (!is_null($id)) $query .= " AND id = :id ";
		// if (!is_null($giorno)) $query .= " AND (Timbratura > :inizio AND Timbratura < :fine)";
		// if (!is_null($annoMese)) $query .= " AND (Timbratura > :inizio AND Timbratura < :fine )";
		$query .= " ORDER BY data DESC, ora DESC ";

		$stmt = $this->conn->prepare($query);

		// BINDING
		if (!is_null($id)) $stmt->bindParam(":id", $id);
		// if (!is_null($giorno) || !is_null($annoMese)) {
		// 	if (!is_null($giorno)) {
		// 		$inizio = $giorno . " 00:00";
		// 		$fine = substr($giorno, 0, 8) . ((int)substr($giorno, 8, 2) + 1) . " 00:00"; // giorno dopo
		// 	}
		// 	if (!is_null($annoMese)) {
		// 		$inizio = $annoMese . "-01 00:00";
		// 		$fine = substr($annoMese, 0, 5) . ((int)substr($annoMese, 5, 2) + 1) . "-01 00:00"; // mese dopo
		// 	}

		// 	$stmt->bindParam(":inizio", $inizio);
		// 	$stmt->bindParam(":fine", $fine);
		// }

		// execute query
		$stmt->execute();
		return $stmt;
	}

	// CREARE timbratura
	function create()
	{
		$query = "INSERT INTO " . $this->table_name . " SET data=:data, ora=:ora, causale=:causale ";

		$stmt = $this->conn->prepare($query);

		//		$this->ID = htmlspecialchars(strip_tags($this->ID));
		$this->data = htmlspecialchars(strip_tags($this->data));
		$this->ora = htmlspecialchars(strip_tags($this->ora));
		$this->causale = htmlspecialchars(strip_tags($this->causale));

		// binding
		// $stmt->bindParam(":ID", $this->ID);
		$stmt->bindParam(":data", $this->data);
		$stmt->bindParam(":ora", $this->ora);
		$stmt->bindParam(":causale", $this->causale);

		// execute query
		if ($stmt->execute()) return true;
		return false;
	}


	// AGGIORNARE timbratura
	function update()
	{

		$query = "UPDATE " . $this->table_name . " SET data = :data, ora = :ora, causale = :causale  WHERE  id = :id";

		$stmt = $this->conn->prepare($query);

		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->data = htmlspecialchars(strip_tags($this->data));
		$this->ora = htmlspecialchars(strip_tags($this->ora));
		$this->causale = htmlspecialchars(strip_tags($this->causale));

		$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":data", $this->data);
		$stmt->bindParam(":ora", $this->ora);
		$stmt->bindParam(":causale", $this->causale);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}


	// CANCELLARE timbratura

	function delete()
	{

		$query = "DELETE FROM " . $this->table_name . " WHERE ID = ?";


		$stmt = $this->conn->prepare($query);

		$this->id = htmlspecialchars(strip_tags($this->id));


		$stmt->bindParam(1, $this->id);

		// execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
