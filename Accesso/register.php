<?php

include_once '../db.php';

class Registrati{

    public function RegistraUsername($nome,$cognome,$cf,$nazione,$città,$provincia,$via,$telefono,$email,$password,$ruolo){
        $DB = new DB();
		try {
			if($nome!="" && $cognome!="" && $cf!="" && $nazione!="" && $città!="" && $provincia!="" && 
               $via !=""  && $telefono!="" && $email!="" && $password!=""){
                $options = [
                    'cost' => 12,
                ];
                $password = password_hash($password, PASSWORD_BCRYPT, $options);
                
                    $query = "INSERT INTO utenti(approvazione, nome, cognome, cf, ruolo, telefono, email, password, nazione, città, provincia, via) 
                              VALUES ('no','$nome','$cognome','$cf','$ruolo','$telefono','$email','$password','$nazione','$città','$provincia','$via');";
                    
                    $stmt = $DB->connect()->query($query);
                
				
                echo "<script type='text/javascript'>alert('La tua registrazione è in attesa di approvazione')</script>";
                header("refresh:0;url=index.html");
            }else{
                echo "<script type='text/javascript'>alert('Non hai compilato tutti i campi')</script>";
                header("refresh:0;url=index.html");
            }
        }catch (PDOException $e) {
			echo "Errore: " . $e->getMessage();

		}
    }

}

$R=new Registrati();
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$cf = $_POST['cf'];
$nazione = $_POST['nazione'];
$città = $_POST['città'];
$provincia = $_POST['provincia'];
$via = $_POST['via'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$password = $_POST['password'];
$ruolo = $_POST['ruolo'];



if($ruolo!=""){
    $R->RegistraUsername($nome,$cognome,$cf,$nazione,$città,$provincia,$via,$telefono,$email,$password,$ruolo);
    
}else{
    echo "<script type='text/javascript'>alert('Non hai inserito il ruolo')</script>";
	header("refresh:0;url=index.html");
}



