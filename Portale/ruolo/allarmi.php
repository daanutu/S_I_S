<?php
include_once '../completesidebar.php';
echo "<script src='../panel.js'></script>";
class Allarmi{

    

    public function allarm()
    {
		
		echo "<script>
		$(document).ready(function(){
			$('#allarm').load('tableallarmi.php')
			setInterval(function(){
				$('#allarm').load('tableallarmi.php')
			},2000);
		});
	  </script>";
	  


		echo "<div id='allarm'>  </div>";
		echo "</div></body></html>";
    }
}

$A = new Allarmi();
$A->allarm(); 
