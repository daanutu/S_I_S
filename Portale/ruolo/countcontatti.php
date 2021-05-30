<?php
include_once '../../db.php';
class CountAllarmiInCorso{

	public function Conta(){	
		$DB = new DB();
		session_start();

		if ( $_SESSION["Ruolo"]!= 'Insegnanti') {

			$query="SELECT COUNT(*) FROM proxy  WHERE status = 1 and timestamp >= CURDATE() ";
		
		}else{

			$query="SELECT COUNT(*)
			FROM proxy, device,alunni,classi 
			WHERE proxy.status = 1
            AND proxy.mybtmac=device.btmac
			AND alunni.id_alunno = device.id
			AND classi.id_classe=".$_SESSION['Id_classe']."
			AND alunni.id_classe = classi.id_classe
			AND proxy.timestamp >= CURDATE()";
			
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


