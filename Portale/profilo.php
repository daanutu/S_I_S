<?php

include_once '../db.php';
include_once 'completesidebar.php';


class Profilo{

    public function Account(){	
        $DB = new DB();
        echo "<div class='login' >
        <div class='login__content'>
            <div class='login__forms'>
                <form action='' method='' class='login__create' id='login-up' style='left: -5rem; bottom: -9.3rem'>
                    <div class='card-container'>";
                    $id = $_SESSION["Id"];
                        $query="SELECT  nome, cognome, cf, ruolo, telefono, email, nazione, città, provincia, via FROM utenti WHERE id_utente = $id";
                        $stmt = $DB->connect()->query($query);	
			            foreach($stmt as $row){
                        echo "<span class='pro'>".$row["ruolo"]."</span>
                        <img class='round' src='../Portale/assets/person.png' width='143px' height='144px' alt='user' />";
                        
                            echo    "<h3 style='color:black'>".$row["nome"]." ".$row["cognome"]."</h3>
                            </div>

                    <div style='overflow-y: scroll; height: 300px;'>

                        <div class='login__box'>
                            <i class='bx  bx-fingerprint login__icon'></i>
                            <input type='text' readonly placeholder='".$row["cf"]."' class='login__input'>
                        </div>

                        <div class='login__box'>
                            <i class='bx bx-world login__icon'></i>
                            <input type='text' readonly placeholder='".$row["nazione"]."' class='login__input'>
                        </div>

                        <div class='login__box'>
                            <i class='bx bxs-city login__icon'></i>
                            <input type='text' readonly placeholder='".$row["città"]."' class='login__input' >
                        </div>

                        <div class='login__box'>
                            <i class='bx bxs-compass login__icon'></i>
                            <input type='text' readonly placeholder='".$row["provincia"]."' class='login__input'>
                        </div>

                        <div class='login__box'>
                            <i class='bx bx-home login__icon'></i>
                            <input type='text' readonly placeholder='".$row["via"]."' class='login__input'>
                        </div>

                        <div class='login__box'>
                            <i class='bx bxs-phone login__icon'></i>
                            <input type='text' readonly placeholder='".$row["telefono"]."' class='login__input'>
                        </div>

                        <div class='login__box'>
                            <i class='bx bx-at login__icon'></i>
                            <input type='text' readonly placeholder='".$row["email"]."' class='login__input'>
                        </div>


                    </div>";
                    }
                echo"</form>
            </div>
        </div>
    </div>

	</div>
    <script src='panel.js'></script>
</body>
</html>";
    }
    

}  
$P = new Profilo();
$P->Account(); 