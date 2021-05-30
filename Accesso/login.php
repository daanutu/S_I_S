<?php

include_once '../db.php';


class Login{

    public function __construct(){
		session_start();
    }

	public function Loggati($email,$password){
		$DB = new DB();
		$flag = false;	
		$query="SELECT utenti.id_utente, utenti.nome, utenti.cognome, utenti.ruolo, utenti.email, utenti.password from utenti 
			  where email = '$email'";
		$stmt = $DB->connect()->query($query);
		if($stmt->rowCount() > 0){
			foreach($stmt as $row){
				if (password_verify($password, $row['password'])){ 
					$flag = true;
					$_SESSION["Nome"] = $row["nome"];
					$_SESSION["Cognome"] = $row["cognome"];
					$_SESSION["Id"] = $row["id_utente"];
					$_SESSION["Ruolo"] = $row["ruolo"];
					break;
				}else
					$flag = false;
			}
		}else{
			echo "<script type='text/javascript'>alert('Non esiste nessuna email')</script>";
            header("refresh:0;url=index.html");
		}

		if($flag == true){
			$query="SELECT * from utenti where email = '$email'";
			$stmt = $DB->connect()->query($query);
			if($stmt->rowCount() > 0){
				foreach($stmt as $row){
					if($row['approvazione'] == "sì"){
						switch ($row['ruolo']) {
							case 'Dirigenza':
								header("refresh:0;url=../Portale/ruolo.php");
								break;

							case 'Segreteria':
								header("refresh:0;url=../Portale/ruolo.php");
								break;

							case 'Insegnanti':
								header("refresh:0;url=../Portale/ruolo.php");
								break;
							
							case 'Responsabile Covid':
								header("refresh:0;url=../Portale/ruolo.php");
								break;
								
							case 'Amministrazione':
								header("refresh:0;url=../Portale/amministrazione.php");
								break;	
						}
						
					}else{
						session_destroy();
						echo "<script type='text/javascript'>alert('La tua richiesta non è stata approvata dall'amministrazione')</script>";
						header("refresh:0;url=index.html");
					}
				}
				
			}
		}else{
			echo "<script type='text/javascript'>alert('Non hai inserito correttamente la password')</script>";
            header("refresh:0;url=index.html");
		}

	}

}

$L=new Login();
$email = $_POST['email'];
$password = $_POST['password'];
$L->Loggati($email,$password);