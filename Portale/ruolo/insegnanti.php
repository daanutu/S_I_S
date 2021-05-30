<?php
include_once '../../db.php';
include_once '../completesidebar.php';
echo "<script src='../panel.js'></script>";

class Insegnanti{

    

    public function ins()
    {
        $DB = new DB();
        echo "<div class='row'>
			<div class='col-8 col-m-12 col-sm-12' style=' margin-left: auto;margin-right: auto;margin-top: 10%;'>
				<div class='card'>
					<div class='card-header'>
						<h3>
							Insegnanti della scuola
						</h3>
						<i class='fas fa-ellipsis-h'></i>
					</div>
					<div class='card-content'>
						<table>
							<thead>
								<tr>
									<th>Nome e Cognome</th>
									<th>Classi</th>
									<th>Cf</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Città</th>
                                    <th>Via</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
							//$query="SELECT nome, cognome, classi.numero,classi.sezione, cf, telefono, email,città, via FROM utenti,classi, insegnano WHERE ruolo='Insegnanti' AND insegnano.id_utente = utenti.id_utente AND insegnano.id_classe=classi.id_classe";	
                            $query="SELECT nome, cognome, cf, telefono, email,città, via FROM utenti,classi, insegnano WHERE ruolo='Insegnanti' AND insegnano.id_utente = utenti.id_utente AND insegnano.id_classe=classi.id_classe GROUP BY nome,cognome";
                            $stmt = $DB->connect()->query($query);	
			                foreach($stmt as $row){
                                echo "<tr><td>".$row["nome"]." ".$row["cognome"]."</td>";

                                $query2="SELECT classi.numero,classi.sezione FROM utenti,classi, insegnano WHERE ruolo='Insegnanti' AND insegnano.id_utente = utenti.id_utente AND insegnano.id_classe=classi.id_classe AND utenti.nome='".$row["nome"]."' AND utenti.cognome='".$row["cognome"]."' AND utenti.cf='".$row["cf"]."'";
                                $stmt2 = $DB->connect()->query($query2);
                                echo "<td>";

                                foreach($stmt2 as $row2){
                                    echo $row2["numero"]." ".$row2["sezione"]."<br>";
                                }
                                echo "</td>";
                                echo "<td>".$row["cf"]."</td> <td>".$row["telefono"]."</td> <td>".$row["email"]."</td> <td>".$row["città"]."</td>
                                <td>".$row["via"]."</td>";
                                        
                            }
                            echo "</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>";

		echo"</div>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js'></script>
	</body>
	</html>";
    }
}

$I = new Insegnanti();
$I->ins(); 
