<?php
include_once '../../db.php';
include_once '../completesidebar.php';
echo "<script src='../panel.js'></script>";


echo "
<form action='Ainserisci.php' method='POST' class='login__create' id='login-up' style='margin-left: 40%; margin-bottom: 20%; width: 50%'>
<h1 class='login__title'>Aggiungi alunno</h1>

<div style='overflow-y: scroll; height: 250px;'>

    <div class='login__box'>
        <i class='bx bx-id-card login__icon'></i>
        <input type='text' placeholder='Nome' class='login__input' required name='nome' >
    </div>

    <div class='login__box'>
        <i class=' bx bx-font-family login__icon'></i>
        <input type='text' placeholder='Cognome' class='login__input' required name='cognome'>
    </div>


    <div class='login__box'>
        <i class='bx bxs-phone login__icon'></i>
        <input type='text' placeholder='Telefono Genitore' class='login__input' required name='telefono'>
    </div>

    <div class='login__box'>
        <i class='bx bx-at login__icon'></i>
        <input type='text' placeholder='Email Genitore' class='login__input' required name='email' >
    </div>";

    echo"<div class='login__box'>
            <i class='bx bx-user-circle login__icon'></i>
            <select required name='classe' class='login__input'>";
            $DB = new DB();
            session_start();
            $query = "SELECT * FROM classi";
            $stmt = $DB->connect()->query($query);
            foreach ($stmt as $row) {
	            $id_classe = $row['id_classe'];
	            echo "<option name='classe' value='$id_classe'>" . $row["numero"] . " " . $row["sezione"] . "</option>";
            }
echo "</select>";

   

echo "</div>

<div align='center'>
    <input type='submit' class='login__button' value='Inserisci Alunno'>
</div>



</form>";
