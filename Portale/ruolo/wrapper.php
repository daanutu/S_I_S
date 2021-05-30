<?php

if ($_SESSION["Ruolo"] != 'Insegnanti') {
	echo "<script>
                    $(document).ready(function(){
                        $('#nallarmi').load('ruolo/countallarmiincorso.php')
						$('#ncontatti').load('ruolo/countcontatti.php')
                        setInterval(function(){
                            $('#nallarmi').load('ruolo/countallarmiincorso.php')
							$('#ncontatti').load('ruolo/countcontatti.php')
                        },900);
                    });
                  </script>";

	echo "<div class='wrapper'>
		<div class='row'>
			<div class='col-3 col-m-6 col-sm-6'>
				<div class='counter bg-warning'>
					<p>
						<i class='fas fa-hands-wash'></i>
					</p>
					<h3 id='ncontatti'></h3>
					<p>Dispositvi a contatto oggi</p>
				</div>
			</div>
			
			<div class='col-3 col-m-6 col-sm-6'>
				<div class='counter bg-danger'>
					<p>
						<i class='fas fa-exclamation-triangle'></i>
					</p>
					<h3 id='nallarmi'></h3>
					<p>Dispositvi in allarme</p>
				</div>
			</div>
		</div>";
} else {
	
	echo "<script>
                    $(document).ready(function(){
                        $('#nallarmi').load('ruolo/countallarmiincorso.php')
						$('#ncontatti').load('ruolo/countcontatti.php')
                        setInterval(function(){
                            $('#nallarmi').load('ruolo/countallarmiincorso.php')
							$('#ncontatti').load('ruolo/countcontatti.php')
                        },6000);
                    });
                  </script>";
	$DB = new DB(); 
	$query1="SELECT classi.id_classe FROM utenti,insegnano,classi 
				WHERE utenti.ruolo='Insegnanti'
				AND utenti.id_utente = ".$_SESSION['Id']."
				AND utenti.id_utente = insegnano.id_utente
				AND insegnano.id_classe = classi.id_classe
				LIMIT 1";
				$stmt = $DB->connect()->query($query1);
				foreach($stmt as $row){
					$_SESSION['Id_classe']=$row["id_classe"];
				}	  
				

	echo "<div class='wrapper'>
		<div class='row'>
	    
		<div class='col-3 col-m-6 col-sm-6'>
		<form method='POST'>
				
					
					<h3>Seleziona la classe</h3>
				
					<select name='classi'  class='login__input'>";
	$DB = new DB();
	$id = $_SESSION["Id"];
	$query = "SELECT  classi.id_classe, classi.numero, classi.sezione FROM classi, insegnano where insegnano.id_utente='$id' AND insegnano.id_classe=classi.id_classe";
	$stmt = $DB->connect()->query($query);
	foreach ($stmt as $row) {
		$id = $row['id'];
		echo "<option name='classi' value=" . $row["id_classe"] . ">" . $row["numero"] . " " . $row["sezione"] . "</option>";
	}
	echo "</select>    <input type='submit' class='login__button' value='Invia'>  </form> </div> 
			


			<div class='col-3 col-m-6 col-sm-6'>
				<div class='counter bg-warning'>
					<p>
						<i class='fas fa-hands-wash'></i>
					</p>
					<h3 id='ncontatti'></h3>
					<p>Dispositvi a contatto oggi</p>
				</div>
			</div>
			
			<div class='col-3 col-m-6 col-sm-6'>
				<div class='counter bg-danger'>
					<p>
						<i class='fas fa-exclamation-triangle'></i>
					</p>
					<h3 id='nallarmi'></h3>
					<p>Dispositvi in allarme</p>
				</div>
			</div>
		</div>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_SESSION["Id_classe"]  = $_POST["classi"];
		}


}
