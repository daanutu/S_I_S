<?php

include_once '../../db.php';
class CountAllarmiInCorso{

	public function Conta(){	
		$DB = new DB();
		session_start();
		
		if ( $_SESSION["Ruolo"]!= 'Insegnanti') {
			$query="SELECT COUNT(*) FROM device where STATUS=1 ";
		}else{
			$query="SELECT COUNT(*) 
			FROM device,alunni,classi 
			where alunni.id_alunno = device.id
			AND classi.id_classe=".$_SESSION['Id_classe']."
			AND alunni.id_classe = classi.id_classe 
			AND device.status=1 ";
		}
		
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


