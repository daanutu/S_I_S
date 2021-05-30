<?php
class DB{
	private $hostname;
	private $dbname;
	private $user;
	private $pass;

	public function connect(){
		try {
			$this->hostname = "localhost";
			$this->dbname = "scuole_in_sicurezza";
			$this->user = "root";
			$this->pass = "";
			$db = new PDO ("mysql:host=$this->hostname;dbname=$this->dbname", $this->user, $this->pass);
			return $db;
		} catch (PDOException $e) {
			echo "Errore: " . $e->getMessage();
		}
    }
	
}



