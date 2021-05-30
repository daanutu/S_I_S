<?php
include_once '../../db.php';
include_once '../completesidebar.php';
echo "<script src='../panel.js'></script>";


echo "
<form action='Dinserisci.php' method='POST' class='login__create' id='login-up' style='margin-left: 40%; margin-bottom: 10%; width: 50%'>
<h1 class='login__title'>Aggiungi dispositivo</h1>

<div style='overflow-y: scroll; height: 250px;'>

    
    <div class='login__box'>
        <i class='bx bx-barcode-reader login__icon'></i>
            <select name='alunno'  class='login__input'>";
        $DB = new DB();
        $query = "SELECT id_alunno, nome,cognome 
        FROM alunni
        WHERE NOT EXISTS (
            SELECT 1
            FROM device
            WHERE device.id = alunni.id_alunno
        )
        ORDER BY id_alunno";
	    $stmt = $DB->connect()->query($query);
	    foreach ($stmt as $row) {
		    echo "<option name='id_alunno' value=" . $row["id_alunno"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
	    }
                

    echo"</select></div>

    <div class='login__box'>
        <i class='bx bx-id-card login__icon'></i>
        <input type='text' placeholder='BTMAC' class='login__input' required name='dispositivo' >
    </div>";



   echo "</div>

<div align='center'>
    <input type='submit' class='login__button' value='Inserisci Dispositivo'>
</div>



</form>";
