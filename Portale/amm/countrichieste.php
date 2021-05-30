<?php
include_once '../../db.php';
class CountAllarmiInCorso{

	public function Conta(){	
		$DB = new DB();

		$query="SELECT COUNT(*) FROM utenti  WHERE approvazione='no'";		
		
		$stmt = $DB->connect()->query($query);
		if($stmt->rowCount() > 0){
			foreach($stmt as $row){
				echo $row["COUNT(*)"];
			}
		}
	}
	
}

$C = new CountAllarmiInCorso();
$C->Conta();


