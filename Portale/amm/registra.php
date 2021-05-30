<?php
include_once '../../db.php';
include_once '../completesidebar.php'; 
echo "<script src='../panel.js'></script>";

echo "<div class='row'>
			<div class='col-8 col-m-12 col-sm-12' style='margin-left: auto;margin-right: auto;margin-top: 10%;'>
				<div class='card'>
					<div class='card-header'>
						<h3>
							Richieste di registrazione
						</h3>
						<i class='fas fa-ellipsis-h'></i>
					</div>
					<div class='card-content'>
                    <form action='richiesta.php' method='POST'>
						<table>
							<thead>
								<tr>
                                    <th></th>
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
                            ORDER BY utenti.ruolo ASC";
                        
                        $stmt = $DB->connect()->query($query);
                        foreach ($stmt as $row) {
                            $id = $row["id_utente"];
                            echo "<tr> <td><input type='checkbox' name='utente' value='$id'></td>
                            <td>" . $row["id_utente"] . "</td> 
                                      <td>" . $row["approvazione"] . "</td>
                                      <td>" . $row["nome"] . " " . $row["cognome"] . "</td>
                                      <td>" . $row["cf"] . "</td> 
                                      <td>" . $row["ruolo"] . "</td> 
                                      <td>" . $row["email"] . "</td> 
                                      <td><span class='dot'><i class='bg-danger'></i> </span></td></tr>";
                
                            
                        }
                        echo "</tbody> </table> ";

                        echo"<div align='center'>
                                <input type='submit' name='accetta' value='Accetta'  class='login__button' />
                             </div>";

                        echo "<form> </div> </div> </div> </div>";                            


echo "</body></html>";