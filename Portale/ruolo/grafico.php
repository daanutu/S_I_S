<?php
include_once '../../db.php';
include_once '../completesidebar.php';

echo "<script src='../panel.js'></script>";
//echo "<link rel='stylesheet' type='text/css' href='proxytable.css'> ";


echo "<div class='row'>
			<div class='col-8 col-m-12 col-sm-12' style='margin-left: auto;margin-right: auto;margin-top: 10%;'>
			<div class='card'>
			<div class='card-content'>
				<form method='POST'>
				<table>
				<thead>
					<tr>
						<th>
						Scegli il dispositivo da analizzare:
						</th>

						<th>
						Scegli la data di inizio:
						</th>

						<th>
						Scegli la data di fine:
						</th>

					</tr>
				</thead>
				<tbody>
				<tr>
				<td>	
            	<div class='login__box'>
				<select name='dispositivo'  class='login__input'>";
$DB = new DB();
session_start();
if($_SESSION["Ruolo"] != 'Insegnanti'){
	$query = "SELECT device.id, device.btmac, alunni.nome, alunni.cognome, classi.numero, classi.sezione 
					FROM device, alunni, classi 
					where device.id = alunni.id_alunno  and alunni.id_classe = classi.id_classe
					ORDER BY classi.sezione ASC; ";
}else{
	$query = "SELECT device.id, device.btmac, alunni.nome, alunni.cognome, classi.numero, classi.sezione 
					FROM device, alunni, classi 
					where device.id = alunni.id_alunno  and alunni.id_classe = classi.id_classe and classi.id_classe=".$_SESSION["Id_classe"]."
					ORDER BY classi.sezione ASC; ";
}

$stmt = $DB->connect()->query($query);
foreach ($stmt as $row) {
	$btmac = $row['btmac'];
	echo "<option name='alunno' value='$btmac'>" . $row['nome'] . " " . $row["cognome"] . "  " . $row["numero"] . " " . $row["sezione"] . "</option>";
}
echo "</select> </td> </div>";


echo "<td> <div class='login__box'>
				<input type='date'  class='login__input' name='datastart'></div></td>
				<td> <div class='login__box'>
				<input type='date'  class='login__input' name='dataend'></div></td>";


echo "<td> <div class='login__box'>
				<input type='submit' class='login__button' value='Vedi situazione'></div></td>";
				
echo " </tr></tbody></table></form> ";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$dispositivo = $_POST["dispositivo"];
	$datastart = $_POST["datastart"];
	$dataend = $_POST["dataend"];

	$q = "SELECT alunni.nome, alunni.cognome FROM alunni,device WHERE alunni.id_alunno= device.id and device.btmac='$dispositivo'";
	$stmt = $DB->connect()->query($q);
	if ($stmt->rowCount() > 0) {
		foreach ($stmt as $row) {
		echo "<div align='center' style='vertical-align: inherit;font-weight: bold; font-size: 150%;'>" . $row["nome"] . " ".$row["cognome"]  . "</div>";
		}
	}
	echo "<br>";

	if ($datastart == '') $datastart = '1970-01-01';
	if ($dataend == '') $dataend = '2286-11-20';
	$query1 = "SELECT t1.id myid, t2.mybtmac mymac, 
	(SELECT DISTINCT t3.id 
	FROM device t3,proxy t4 
	WHERE t3.btmac=t4.otherbtmac AND t4.otherbtmac=t2.otherbtmac) othid, t2.otherbtmac othmac, t2.status st, t2.timestamp ts, t2.duration dur 
	FROM proxy t2,device t1 WHERE t2.mybtmac=t1.btmac AND t2.mybtmac='$dispositivo' AND t2.timestamp>='$datastart' AND t2.timestamp<='$dataend' ORDER BY t2.timestamp";
	echo "<table>
				<thead>
					<tr>
						<th>myid</th>
						<th>mymac</th>
						<th>otherid</th>
						<th>otherbtmac</th>
						<th>Stato</th>
						<th>Durata</th>
						<th></th>
					</tr>
				</thead>
				<tbody>";
	$stmt = $DB->connect()->query($query1);
	if ($stmt->rowCount() > 0) {
		foreach ($stmt as $row) {
			echo "<tr><td>" . $row["myid"] . "</td>
				<td>" . $row["mymac"] . "</td>
				<td>" . $row["othid"] . "</td>
				<td>" . $row["othmac"] . "</td>
				<td>" . $row["st"] . "</td>
				<td>" . $row["dur"] . "</td><tr>";
		}
		echo "</tbody> </table>";
	}
}


echo "</div></div></div>";
