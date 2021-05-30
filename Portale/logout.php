<?php

include_once '../db.php';


class Logout{

	public function __construct(){
	    try {
			session_start();
			if(isset($_GET['logout'])){
				$DB = new DB();
				session_destroy();
				header("refresh:0;url=../index.html");
			}
	    } catch (PDOException $e) {
			echo "Errore: " . $e->getMessage();
		}

    }
	
}

$L = new Logout();


