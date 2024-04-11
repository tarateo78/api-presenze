<?php
include_once './config/database.php';

$db = new Database();
$conn = $db->getConnection();


echo 'php Works!';

echo '<br><br>';

if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "::1") {
	// $sottocartella = "";
	// $path = realpath(dirname(__FILE__) . "/..");
	echo 'locale';
} else {
	// $sottocartella = "benoeditore/";
	// $path = realpath(dirname(__FILE__) . "/..");
	echo 'online';
}

echo '<br><br>';

?>


<h1>ECCO</h1>