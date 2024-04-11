<?php
class Timbratura
{
	private $conn;
	private $table_name = "biag_timbrature";

	// proprietà di una timbratura
	public $ID;
	public $Timbratura;
	public $Causale;

	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}

	// READ timbrature
	function read($giorno)
	{
		// select all
		$query = "SELECT a.ID, a.Timbratura, a.Causale FROM " . $this->table_name . " a ";
		if (!is_null($giorno)) $query .= " WHERE Timbratura > :inizio AND Timbratura < :fine";
		$stmt = $this->conn->prepare($query);

		if (!is_null($giorno)) {
			$inizio = $giorno . " 00:00";
			$fine = $giorno . " 23:59";

			$stmt->bindParam(":inizio", $inizio);
			$stmt->bindParam(":fine", $fine);
		}

		// execute query
		$stmt->execute();
		return $stmt;
	}

	// CREARE timbratura
	function create()
	{
		$query = "INSERT INTO " . $this->table_name . " SET Timbratura=:timbratura, Causale=:causale ";

		$stmt = $this->conn->prepare($query);

		//		$this->ID = htmlspecialchars(strip_tags($this->ID));
		$this->Timbratura = htmlspecialchars(strip_tags($this->Timbratura));
		$this->Causale = htmlspecialchars(strip_tags($this->Causale));

		// binding
		// $stmt->bindParam(":ID", $this->ID);
		$stmt->bindParam(":timbratura", $this->Timbratura);
		$stmt->bindParam(":causale", $this->Causale);

		// execute query
		if ($stmt->execute()) return true;
		return false;
	}
	/*
	// AGGIORNARE timbratura
	function update()
	{

		$query = "UPDATE " . $this->table_name . "
            SET
                Titolo = :titolo,
                Autore = :autore
            WHERE
                ISBN = :isbn";

		$stmt = $this->conn->prepare($query);

		$this->ISBN = htmlspecialchars(strip_tags($this->ISBN));
		$this->Autore = htmlspecialchars(strip_tags($this->Autore));
		$this->Titolo = htmlspecialchars(strip_tags($this->Titolo));

		// binding
		$stmt->bindParam(":isbn", $this->ISBN);
		$stmt->bindParam(":autore", $this->Autore);
		$stmt->bindParam(":titolo", $this->Titolo);

		// execute the query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}


	// CANCELLARE timbratura

	function delete()
	{

		$query = "DELETE FROM " . $this->table_name . " WHERE ISBN = ?";


		$stmt = $this->conn->prepare($query);

		$this->ISBN = htmlspecialchars(strip_tags($this->ISBN));


		$stmt->bindParam(1, $this->ISBN);

		// execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
	*/
}
