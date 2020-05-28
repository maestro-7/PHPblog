<?php

 class DB_Connection {

 	private $conn;
	
	protected function connect() { 	

		$host = "remotemysql.com";
		$user = "user2311";
		$password = "123456789";
		$dbname = "myheroku";

		$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

		try {
			$this->conn = new PDO($dsn, $user, $password);
			$this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $this->conn;
		} catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}
}
	
?>
