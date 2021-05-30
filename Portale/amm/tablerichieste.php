<?php
//include_once '../../db.php';
class CountAllarmiInCorso
{

	public function Conta()
	{
		echo "<div class='row'>
			<div class='col-8 col-m-12 col-sm-12' style='margin-left: 7%;'>
				<div class='card'>
					<div class='card-header'>
						<h3>
							Approva le richeiste di registrazione
						</h3>
						<i class='fas fa-ellipsis-h'></i>
					</div>
					<div class='card-content'>
						<table>
							<thead>
								<tr>
								
									<th>#</th>
									<th>Approvazione</th>
									<th>Nome Cognome</th>
                                    <th>CF</th>
									<th>Ruolo</th>
									<th>Email</th>
									<th></th>
				
								</tr>
							</thead>
							<tbody>";
		
		$DB = new DB();
		

		
			$query = "SELECT utenti.id_utente, utenti.approvazione, utenti.nome, utenti.cognome, utenti.cf, utenti.ruolo, utenti.email
			FROM utenti
			WHERE utenti.approvazione='no'
			ORDER BY utenti.ruolo ASC LIMIT 5 ";
		

		
		$stmt = $DB->connect()->query($query);
		foreach ($stmt as $row) {
			
			echo "<tr> <td>" . $row["id_utente"] . "</td> 
					  <td>" . $row["approvazione"] . "</td>
                      <td>" . $row["nome"] . " " . $row["cognome"] . "</td>
					  <td>" . $row["cf"] . "</td> 
					  <td>" . $row["ruolo"] . "</td> 
					  <td>" . $row["email"] . "</td> 
					  <td><span class='dot'><i class='bg-danger'></i> </span></td></tr>";

			
		}
		echo "</tbody> </table> </div> </div> </div> </div>";
	}
}

$C = new CountAllarmiInCorso();
$C->Conta();
