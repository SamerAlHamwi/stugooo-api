<?php

session_start();
date_default_timezone_set('Africa/Casablanca');
error_reporting(0);

class con extends SQLite3 {

	function __construct() {
		$this->open("database.db");
	}

	function command($connection,$cmd) {
		return $connection->query($cmd);
	}

	function MyData($data) {
		$my_array = [];
		while( $row = $data->fetchArray(SQLITE3_ASSOC) ) {
			$my_array[] = $row;
		}
		return $my_array;
	}

}

$connexion = new con();

include_once 'functions.php';
?>