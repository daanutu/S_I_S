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
                                    <th>#</th>
									<th>Appartenente</th>
									<th>Classe</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
		
		$DB = new DB();
		session_start();

		
		$query2 = "SELECT d.id as id1, a.nome as nome1, a.cognome as cognome1, c.numero as numero1, c.sezione as sezione1, d1.id as id2, a1.nome as nome2, a1.cognome as cognome2, c1.numero as numero2, c1.sezione as sezione2
					FROM temp,device d, device d1, alunni a, alunni a1, classi c, classi c1
					WHERE temp.bt=d.btmac AND temp.bt2=d1.btmac AND a.id_alunno=d.id AND a1.id_alunno=d1.id AND
					c.id_classe=a.id_classe AND c1.id_classe=a1.id_classe;";

		
		
		
		
		
		$stmt = $DB->connect()->query($query2);
		
		foreach ($stmt as $row) {
			echo "<tr><td>" . $row["id1"] . "</td> <td>" . $row["nome1"] . " " . $row["cognome1"] . "</td> <td>" . $row["numero1"] . " " . $row["sezione1"] . "</td>
			<td>" . $row["id2"] . "</td> <td>" . $row["nome2"] . " " . $row["cognome2"] . "</td> <td>" . $row["numero2"] . " " . $row["sezione2"] . "</td>
			</tr>";

			
		}
	}
}

$C = new CountAllarmiInCorso();
$C->Conta();
