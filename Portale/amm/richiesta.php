<?php
include_once '../../db.php';
$DB = new DB();

if(isset($_POST["utente"])){
    $utente= $_POST["utente"];
    $query = "UPDATE utenti SET approvazione = 'sì' WHERE utenti.id_utente = $utente;";
    $stmt = $DB->connect()->query($query);
    echo "<script type='text/javascript'>alert('Richiesta accettata')</script>";
    header("refresh:0;url=registra.php");
}else{
    echo "<script type='text/javascript'>alert('Non hai selezionato un utente')</script>";
            header("refresh:0;url=registra.php");
}

	

