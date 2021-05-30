<?php
include_once '../../db.php';
class Situazione{

	public function Visualizza($dispositivo,$datastart,$dataend){	
		

		$DB = new DB();
		$query="SELECT t1.id myid, t2.mybtmac mymac, 
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
		$stmt = $DB->connect()->query($query);
		if($stmt->rowCount() > 0){
			foreach($stmt as $row){
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
	
}

$S = new Situazione();
$dispositivo = $_POST["dispositivo"];
$datastart = $_POST["datastart"];
$dataend = $_POST["dataend"];
if($datastart=='') $datastart='1970-01-01';
if($dataend=='') $dataend='2286-11-20';
$S->Visualizza($dispositivo,$datastart,$dataend);
//echo $dispositivo,$datastart,$dataend;

