<?php
class Database
{
	// credenziali
	private $host = "localhost";
	private $db_name = "my_tarateo";
	private $username = "tarateo";
	private $password = "";
	public $conn;

	public function __construct()
	{
		// verifica se locale oppure online
		if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "::1") {
			$this->host = "localhost";
			$this->db_name = "biagiometro";
			$this->username = "root";
			$this->password = "root";
		} else {
			$this->host = "localhost";
			$this->db_name = "my_matteotarabini";
			$this->username = "matteotarabini";
			$this->password = "";
		}
	}

	// connessione al database
	public function getConnection()
	{
		$this->conn = null;
		try {
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->exec("set names utf8");
		} catch (PDOException $exception) {
			echo "Errore di connessione: " . $exception->getMessage();
		}
		return $this->conn;
	}
}
