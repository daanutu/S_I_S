<?php
include_once '../../db.php';
$DB = new DB();

$dispositivo= $_POST["dispositivo"];
$alunno= $_POST["alunno"];



$query = "INSERT INTO device(id,btmac, status) VALUES ('$alunno','$dispositivo','0');";

$stmt = $DB->connect()->query($query);
echo "<script type='text/javascript'>alert('Inserimento andato a buon fine')</script>";
header("refresh:0;url=inseriscidispositivi.php");


	

