<?php
include_once '../../db.php';
class CountAllarmiInCorso
{

	public function Conta()
	{
		echo "<div class='row'>
			<div class='col-8 col-m-12 col-sm-12' style='margin-left: auto;margin-right: auto;margin-top: 10%;'>
				<div class='card'>
					<div class='card-header'>
						<h3>
							Stato dispositivi
						</h3>
						<i class='fas fa-ellipsis-h'></i>
					</div>
					<div class='card-content'>
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Appartenente</th>
									<th>Classe</th>
                                    <th>Stato</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
		
		$DB = new DB();
		session_start();

		if ( $_SESSION["Ruolo"]!= 'Insegnanti') {
			$query = "SELECT device.id, alunni.nome, alunni.cognome, classi.numero, classi.sezione, device.status 
					  FROM device,alunni, classi 
				      WHERE device.id = alunni.id_alunno AND alunni.id_classe = classi.id_classe 
					  ORDER BY classi.sezione ASC";
		}else{
			$query = "SELECT device.id, alunni.nome, alunni.cognome, classi.numero, classi.sezione, device.status 
			FROM device,alunni, classi 
			WHERE device.id = alunni.id_alunno AND alunni.id_classe = classi.id_classe 
		    AND classi.id_classe=".$_SESSION['Id_classe']."
			ORDER BY classi.sezione ASC";

		}
		
		//$query = "SELECT device.id, alunni.nome, alunni.cognome, classi.numero, classi.sezione, device.status FROM device,alunni, classi WHERE device.id = alunni.id_alunno AND alunni.id_classe = classi.id_classe ORDER BY classi.sezione ASC  ";
		$stmt = $DB->connect()->query($query);
		foreach ($stmt as $row) {
			echo "<tr><td>" . $row["id"] . "</td>
                   <td>" . $row["nome"] . " " . $row["cognome"] . "</td> <td>" . $row["numero"] . " " . $row["sezione"] . "</td>";

			if ($row["status"] == 0) {
				echo "<td>Verde</td>
                                            
                     <td><span class='dot'><i class='bg-success'></i> </span></td></tr>";
			} else {
				echo "<td>Rosso</td>
                                            
                      <td><span class='dot'><i class='bg-danger'></i> </span></td></tr>";
			}
			
		}
	}
}

$C = new CountAllarmiInCorso();
$C->Conta();
