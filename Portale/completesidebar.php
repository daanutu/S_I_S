<?php
class sidebar
{
    public function sb()
    {
        session_start();
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $delimitator = "Portale/";
        $pos = strpos($actual_link, $delimitator);
        $url = substr($actual_link, $pos + strlen($delimitator), strlen($actual_link) - 1);


        echo "<!DOCTYPE html>
        <html>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0'>
        <link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css'>
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css2?family=Roboto&display=swap' rel='stylesheet'> 
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
        </head>";

        if (strpos($url, '/') !== false) {
            echo "<link rel='stylesheet' type='text/css' href='../fontawesome-free/css/all.min.css'>
            <link rel='stylesheet' href='../../Accesso/assets/css/styles.css'>
            <link rel='stylesheet' type='text/css' href='../style.css'> ";
        } else {
            echo "<link rel='stylesheet' type='text/css' href='fontawesome-free/css/all.min.css'>
            <link rel='stylesheet' href='../Accesso/assets/css/styles.css'>
            <link rel='stylesheet' type='text/css' href='style.css'> ";
        }

        echo "<body class='overlay-scrollbar'>";


        if (strpos($url, '/') !== false) {
            echo "<div class='navbar'>
		<ul class='navbar-nav'>
			<li class='nav-item'>
				<a class='nav-link'>
					<i class='fas fa-bars' onclick='collapseSidebar()'></i>
				</a>
			</li>
			<li class='nav-item'>
				<img src='../assets/logo-black.png' alt='logo' class='logo logo-light'>
			</li>
		</ul>
		<ul class='navbar-nav nav-right'>
			<li class='nav-item avt-wrapper'>
				<div class='avt dropdown'>
					<img src='../assets/person.png' alt='User image' class='dropdown-toggle' data-toggle='user-menu'>
					<ul id='user-menu' class='dropdown-menu'>
						<li  class='dropdown-menu-item'>
							<a href='../profilo.php'class='dropdown-menu-link'>
								<div>
									<i class='fas fa-user-tie'></i>
								</div>
								<span>Profilo</span>
							</a>
						</li>
						<li  class='dropdown-menu-item'>
							<a href='../logout.php?logout' class='dropdown-menu-link'>
								<div>
									<i class='fas fa-sign-out-alt'></i>
								</div>
								<span>Logout</span>
							</a>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	</div>";
        } else {
            echo "<div class='navbar'>
		<ul class='navbar-nav'>
			<li class='nav-item'>
				<a class='nav-link'>
					<i class='fas fa-bars' onclick='collapseSidebar()'></i>
				</a>
			</li>
			<li class='nav-item'>
				<img src='assets/logo-black.png' alt='logo' class='logo logo-light'>
			</li>
		</ul>
		<ul class='navbar-nav nav-right'>
			<li class='nav-item avt-wrapper'>
				<div class='avt dropdown'>
					<img src='assets/person.png' alt='User image' class='dropdown-toggle' data-toggle='user-menu'>
					<ul id='user-menu' class='dropdown-menu'>
						<li  class='dropdown-menu-item'>
							<a href='profilo.php'class='dropdown-menu-link'>
								<div>
									<i class='fas fa-user-tie'></i>
								</div>
								<span>Profilo</span>
							</a>
						</li>
						<li  class='dropdown-menu-item'>
							<a href='logout.php?logout' class='dropdown-menu-link'>
								<div>
									<i class='fas fa-sign-out-alt'></i>
								</div>
								<span>Logout</span>
							</a>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	</div>";
        }


        echo "<div class='sidebar'>
                <ul class='sidebar-nav'>";

        switch ($_SESSION["Ruolo"]) {
            case 'Dirigenza':
                if (strpos($url, '/') !== false) {
                    $delimitator = "/";
                    $pos = strpos($url, $delimitator);
                    $urlpath = substr($url, $pos + strlen($delimitator), strlen($url) - 1);
                    echo "<li class='sidebar-nav-item'>
                            <a href='../ruolo.php' class='sidebar-nav-link'>
                            <div> <i class='fas fa-tachometer-alt'></i></div>
                            <span> Dashboard</span> </a> </li>";
                    switch ($urlpath) {
                        case 'dispositvi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li></ul></div>";
                            break;
                        case 'allarmi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li></ul></div>";
                            break;
                        case 'grafico.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li></ul></div>";
                            break;
                    }
                } else {
                    echo "<li class='sidebar-nav-item'>
            <a href='ruolo.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-tachometer-alt'></i></div>
                <span>Dashboard </span> </a> </li>
                <li  class='sidebar-nav-item'>
                <a href='ruolo/dispositvi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-paw'></i></div>
                    <span>Stato dispositivi</span> </a> </li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/allarmi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-exclamation-triangle'></i></div>
                    <span>Dispositivi in allarme</span> </a></li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/grafico.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-calendar-week'></i> </div>
                    <span>Tracciamento</span></a></li></ul> </div>";
                }
                break;
            case 'Responsabile Covid':
                if (strpos($url, '/') !== false) {
                    $delimitator = "/";
                    $pos = strpos($url, $delimitator);
                    $urlpath = substr($url, $pos + strlen($delimitator), strlen($url) - 1);
                    echo "<li class='sidebar-nav-item'>
                            <a href='../ruolo.php' class='sidebar-nav-link'>
                            <div> <i class='fas fa-tachometer-alt'></i></div>
                            <span> Dashboard</span> </a> </li>";
                    switch ($urlpath) {
                        case 'dispositvi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
            <a href='istogramma.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-chart-line'></i> </div>
                <span>Grafico andamento</span></a></li></ul></div>";
                            break;
                        case 'allarmi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
            <a href='istogramma.php' class='sidebar-nav-link '>
                <div> <i class='fas fa-chart-line'></i> </div>
                <span>Grafico andamento</span></a></li></ul></div>";
                            break;
                        case 'grafico.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
            <a href='istogramma.php' class='sidebar-nav-link '>
                <div> <i class='fas fa-chart-line'></i> </div>
                <span>Grafico andamento</span></a></li></ul></div>";
                            break;
                        case 'istogramma.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
            <a href='istogramma.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-chart-line'></i> </div>
                <span>Grafico andamento</span></a></li></ul></div>";
                            break;    
                    }
                } else {
                    echo "<li class='sidebar-nav-item'>
            <a href='ruolo.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-tachometer-alt'></i></div>
                <span>Dashboard </span> </a> </li>
                <li  class='sidebar-nav-item'>
                <a href='ruolo/dispositvi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-paw'></i></div>
                    <span>Stato dispositivi</span> </a> </li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/allarmi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-exclamation-triangle'></i></div>
                    <span>Dispositivi in allarme</span> </a></li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/grafico.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-calendar-week'></i> </div>
                    <span>Tracciamento</span></a></li>
                    <li  class='sidebar-nav-item'>
            <a href='ruolo/istogramma.php' class='sidebar-nav-link '>
                <div> <i class='fas fa-chart-line'></i> </div>
                <span>Grafico andamento</span></a></li></ul> </div>";
                }
                break;
                case 'Segreteria':
                if (strpos($url, '/') !== false) {
                    $delimitator = "/";
                    $pos = strpos($url, $delimitator);
                    $urlpath = substr($url, $pos + strlen($delimitator), strlen($url) - 1);
                    echo "<li class='sidebar-nav-item'>
                            <a href='../ruolo.php' class='sidebar-nav-link'>
                            <div> <i class='fas fa-tachometer-alt'></i></div>
                            <span> Dashboard</span> </a> </li>";
                    switch ($urlpath) {
                        case 'dispositvi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
                <a href='insegnanti.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-chalkboard-teacher'></i> </div>
                    <span>Insegnanti</span></a></li> </ul></div>";
                            break;
                        case 'allarmi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
                <a href='insegnanti.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-chalkboard-teacher'></i> </div>
                    <span>Insegnanti</span></a></li> </ul></div>";
                            break;
                        case 'grafico.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
                <a href='insegnanti.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-chalkboard-teacher'></i> </div>
                    <span>Insegnanti</span></a></li> </ul></div>";
                            break;
                        case 'insegnanti.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link '>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li>
                <li  class='sidebar-nav-item'>
                <a href='insegnanti.php' class='sidebar-nav-link active'>
                    <div> <i class='fas fa-chalkboard-teacher'></i> </div>
                    <span>Insegnanti</span></a></li> </ul></div>";
                            break;    
                            
                    }
                } else {
                    echo "<li class='sidebar-nav-item'>
            <a href='ruolo.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-tachometer-alt'></i></div>
                <span>Dashboard </span> </a> </li>
                <li  class='sidebar-nav-item'>
                <a href='ruolo/dispositvi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-paw'></i></div>
                    <span>Stato dispositivi</span> </a> </li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/allarmi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-exclamation-triangle'></i></div>
                    <span>Dispositivi in allarme</span> </a></li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/grafico.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-calendar-week'></i> </div>
                    <span>Tracciamento</span></a></li>
                    <li  class='sidebar-nav-item'>
                <a href='ruolo/insegnanti.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-chalkboard-teacher'></i> </div>
                    <span>Insegnanti</span></a></li> </ul> </div>";
                }
                break;
                case 'Insegnanti':
                if (strpos($url, '/') !== false) {
                    $delimitator = "/";
                    $pos = strpos($url, $delimitator);
                    $urlpath = substr($url, $pos + strlen($delimitator), strlen($url) - 1);
                    echo "<li class='sidebar-nav-item'>
                            <a href='../ruolo.php' class='sidebar-nav-link'>
                            <div> <i class='fas fa-tachometer-alt'></i></div>
                            <span> Dashboard</span> </a> </li>";
                    switch ($urlpath) {
                        case 'dispositvi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li></ul></div>";
                            break;
                        case 'allarmi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li></ul></div>";
                            break;
                        case 'grafico.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='dispositvi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-paw'></i></div>
                <span>Stato dispositivi</span> </a> </li>
        <li  class='sidebar-nav-item'>
            <a href='allarmi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-exclamation-triangle'></i></div>
                <span>Dispositivi in allarme</span> </a></li>
        <li  class='sidebar-nav-item'>
            <a href='grafico.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-calendar-week'></i> </div>
                <span>Tracciamento</span></a></li></ul></div>";
                            break;
                    }
                } else {
                    echo "<li class='sidebar-nav-item'>
            <a href='ruolo.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-tachometer-alt'></i></div>
                <span>Dashboard </span> </a> </li>
                <li  class='sidebar-nav-item'>
                <a href='ruolo/dispositvi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-paw'></i></div>
                    <span>Stato dispositivi</span> </a> </li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/allarmi.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-exclamation-triangle'></i></div>
                    <span>Dispositivi in allarme</span> </a></li>
            <li  class='sidebar-nav-item'>
                <a href='ruolo/grafico.php' class='sidebar-nav-link'>
                    <div> <i class='fas fa-calendar-week'></i> </div>
                    <span>Tracciamento</span></a></li></ul> </div>";
                }
                break;
                case 'Amministrazione':
                if (strpos($url, '/') !== false) {
                    $delimitator = "/";
                    $pos = strpos($url, $delimitator);
                    $urlpath = substr($url, $pos + strlen($delimitator), strlen($url) - 1);
                    echo "<li class='sidebar-nav-item'>
                            <a href='../amministrazione.php' class='sidebar-nav-link'>
                            <div> <i class='fas fa-tachometer-alt'></i></div>
                            <span> Dashboard</span> </a> </li>";
                    switch ($urlpath) {
                        case 'registra.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='registra.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-users'></i></div>
                <span>Accettare la registrazione</span> </a> </li>
                <li  class='sidebar-nav-item'>
            <a href='inseriscialunni.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-child'></i></div>
                <span>Inserisci alunni</span> </a></li>
                <li  class='sidebar-nav-item'>
            <a href='inseriscialunni.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-sliders-h'></i></div>
                <span>Inserisci Device</span> </a></li></ul></div>";
                            break;
                        case 'inseriscialunni.php':
                          echo "<li  class='sidebar-nav-item'>
            <a href='registra.php' class='sidebar-nav-link '>
                <div> <i class='fas fa-users'></i></div>
                <span>Accettare la registrazione</span> </a> </li>
                <li  class='sidebar-nav-item'>
            <a href='inseriscialunni.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-child'></i></div>
                <span>Inserisci alunni</span> </a></li>
                <li  class='sidebar-nav-item'>
            <a href='inseriscidispositivi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-sliders-h'></i></div>
                <span>Inserisci Device</span> </a></li></ul></div>";
                            break;
                        case 'inseriscidispositivi.php':
                            echo "<li  class='sidebar-nav-item'>
            <a href='registra.php' class='sidebar-nav-link '>
                <div> <i class='fas fa-users'></i></div>
                <span>Accettare la registrazione</span> </a> </li>
                <li  class='sidebar-nav-item'>
            <a href='inseriscialunni.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-child'></i></div>
                <span>Inserisci alunni</span> </a></li>
                <li  class='sidebar-nav-item'>
            <a href='inseriscidispositivi.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-sliders-h'></i></div>
                <span>Inserisci Device</span> </a></li></ul></div>";
                            break;
                    }
                } else {
                    echo "<li class='sidebar-nav-item'>
            <a href='amministrazione.php' class='sidebar-nav-link active'>
                <div> <i class='fas fa-tachometer-alt'></i></div>
                <span>Dashboard </span> </a> </li>
                <li  class='sidebar-nav-item'>
            <a href='amm/registra.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-users'></i></div>
                <span>Accettare la registrazione</span> </a> </li>
                    <li  class='sidebar-nav-item'>
            <a href='amm/inseriscialunni.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-child'></i></div>
                <span>Inserisci alunni</span> </a></li>
                 <li  class='sidebar-nav-item'>
            <a href='amm/inseriscidispositivi.php' class='sidebar-nav-link'>
                <div> <i class='fas fa-sliders-h'></i></div>
                <span>Inserisci Device</span> </a></li></ul></div>";
                }
                break;
                
        }
    }
}

$S = new sidebar();
$S->sb();
