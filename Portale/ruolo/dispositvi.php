<?php
include_once '../completesidebar.php';
echo "<script src='../panel.js'></script>";

class Dispositivi{

    

    public function disp()
    {
		echo "<script>
		$(document).ready(function(){
			$('#status').load('tabledispositivi.php')
			setInterval(function(){
				$('#status').load('tabledispositivi.php')
			},900);
		});
	  </script>";


		echo "<div id='status'>  </div>";
		echo "</div></body></html>";
    }
}

$D = new Dispositivi();
$D->disp(); 
