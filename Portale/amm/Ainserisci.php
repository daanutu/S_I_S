<?php
include_once '../../db.php';
$DB = new DB();

$nome= $_POST["nome"];
$cognome= $_POST["cognome"];
$telefono= $_POST["telefono"];
$email= $_POST["email"];
$classe= $_POST["classe"];


$query = "INSERT INTO alunni(nome, cognome, telefono_genitore, email_genitore, id_classe) VALUES ('$nome','$cognome','$telefono','$email','$classe');";

$stmt = $DB->connect()->query($query);
echo "<script type='text/javascript'>alert('Inserimento andato a buon fine')</script>";
header("refresh:0;url=inseriscialunni.php");


	

